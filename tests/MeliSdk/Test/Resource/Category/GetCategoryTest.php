<?php

namespace Tecnogo\MeliSdk\Test\Resource\Cateogory;

use Tecnogo\MeliSdk\Client;
use Tecnogo\MeliSdk\Entity\Category\Category;
use Tecnogo\MeliSdk\Test\Resource\AbstractResourceTest;
use Tecnogo\MeliSdk\Test\Resource\CreateMapResponseGetRequest;

class GetCategoryTest extends AbstractResourceTest
{
    use CreateMapResponseGetRequest;

    /**
     * @param Client $client
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\BadRequestException
     * @throws \Tecnogo\MeliSdk\Request\Exception\ForbiddenResourceException
     * @throws \Tecnogo\MeliSdk\Request\Exception\InvalidTokenException
     * @throws \Tecnogo\MeliSdk\Request\Exception\NotFoundException
     * @throws \Tecnogo\MeliSdk\Request\Exception\UnexpectedHttpResponseCodeException
     * @throws \Tecnogo\MeliSdk\Request\Exception\UnknownHttpMethodException
     */
    protected function triggerRequestForErrorResponses(Client $client)
    {
        // We need to use any "getter" method to trigger the lazy loading
        $client->category('blah')->raw();
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\BadRequestException
     * @throws \Tecnogo\MeliSdk\Request\Exception\ForbiddenResourceException
     * @throws \Tecnogo\MeliSdk\Request\Exception\InvalidTokenException
     * @throws \Tecnogo\MeliSdk\Request\Exception\NotFoundException
     * @throws \Tecnogo\MeliSdk\Request\Exception\UnexpectedHttpResponseCodeException
     * @throws \Tecnogo\MeliSdk\Request\Exception\UnknownHttpMethodException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testGetCategory()
    {
        $client = $this->getClientWithFixedGetResponse(
            200,
            file_get_contents(__DIR__ . '/Fixture/categories_MLA5725.json')
        );

        $category = $client->category('MLA5725');

        $this->assertInstanceOf(Category::class, $category);
        $this->assertEquals($category->id(), 'MLA5725');
        $this->assertEquals($category->name(), 'Accesorios para Vehículos');
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\BadRequestException
     * @throws \Tecnogo\MeliSdk\Request\Exception\ForbiddenResourceException
     * @throws \Tecnogo\MeliSdk\Request\Exception\InvalidTokenException
     * @throws \Tecnogo\MeliSdk\Request\Exception\NotFoundException
     * @throws \Tecnogo\MeliSdk\Request\Exception\UnexpectedHttpResponseCodeException
     * @throws \Tecnogo\MeliSdk\Request\Exception\UnknownHttpMethodException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testGetCategoryPath()
    {
        $client = $this->getClientWithMapGetResponse([
            'categories/MLA4711' => [200, file_get_contents(__DIR__ . '/Fixture/categories_MLA4711.json')],
            'categories/MLA4712' => [200, file_get_contents(__DIR__ . '/Fixture/categories_MLA4712.json')],
            'categories/MLA5725' => [200, file_get_contents(__DIR__ . '/Fixture/categories_MLA5725.json')],
        ]);

        $category = $client->category('MLA4712');

        $this->assertInstanceOf(Category::class, $category);
        $this->assertEquals($category->id(), 'MLA4712');
        $this->assertEquals($category->path()->count(), 3);

        $this->assertInstanceOf(Category::class, $category->parent());
        $this->assertEquals($category->parent()->id(), 'MLA4711');
        $this->assertEquals($category->parent()->path()->count(), 2);

        $this->assertInstanceOf(Category::class, $category->parent()->parent());
        $this->assertEquals($category->parent()->parent()->id(), 'MLA5725');
        $this->assertEquals($category->parent()->parent()->path()->count(), 1);

        $this->assertNull($category->parent()->parent()->parent());
    }
}
