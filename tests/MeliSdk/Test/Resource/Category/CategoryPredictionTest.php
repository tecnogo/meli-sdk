<?php

namespace Tecnogo\MeliSdk\Test\Resource\Category;

use Tecnogo\MeliSdk\Client;
use Tecnogo\MeliSdk\Entity\Category\Category;
use Tecnogo\MeliSdk\Entity\Category\CategoryPrediction;
use Tecnogo\MeliSdk\Entity\Category\CategoryPredictionPath;
use Tecnogo\MeliSdk\Test\Resource\AbstractResourceTest;
use Tecnogo\MeliSdk\Test\Resource\CreateMapResponseGetRequest;

class CategoryPredictionTest extends AbstractResourceTest
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
        $this->clearCache($client);
        $client->predictCategory('jabon nivea');
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
    public function testGetCategoryPrediction()
    {
        $client = $this->getClientWithMapGetResponse([
            'sites/MLA/category_predictor/predict?title=kawasaki+klr+650' => [
                200,
                file_get_contents(__DIR__ . '/Fixture/sites_MLA_category_predictor_predict_title_kawasaki_klr_650.json')
            ],
            'categories/MLA407271' => [
                200, file_get_contents(__DIR__ . '/Fixture/categories_MLA407271.json')
            ],
            'categories/MLA403963' => [
                200, file_get_contents(__DIR__ . '/Fixture/categories_MLA403963.json')
            ]
        ]);

        $prediction = $client->predictCategory('kawasaki klr 650');

        $this->assertInstanceOf(CategoryPrediction::class, $prediction);
        $this->assertEquals($prediction->predictionProbability(), 0.411462214); // dat precision
        $this->assertInstanceOf(Category::class, $prediction->category());
        $this->assertEquals($prediction->category()->id(), 'MLA407271');

        $this->assertInstanceOf(CategoryPredictionPath::class, $prediction->path());
        $this->assertInstanceOf(CategoryPrediction::class, $prediction->path()->first());
        $this->assertEquals($prediction->path()->count(), 5);

        $this->assertInstanceOf(CategoryPrediction::class, $prediction->parent());
        $this->assertEquals($prediction->parent()->predictionProbability(), 0.411462213);
        $this->assertInstanceOf(Category::class, $prediction->parent()->category());
        $this->assertEquals($prediction->parent()->category()->id(), 'MLA403963');
    }

    /**
     * @param Client $client
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     */
    protected function clearCache(Client $client)
    {
        $client
            ->make(\Tecnogo\MeliSdk\Entity\Category\Api\GetCategoryPrediction::class)
            ->cache()
            ->clear();
    }
}
