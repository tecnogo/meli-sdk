<?php

namespace Tecnogo\MeliSdk\Test\Resource\Category;

use Tecnogo\MeliSdk\Client;
use Tecnogo\MeliSdk\Entity\Category\Attribute\Attribute;
use Tecnogo\MeliSdk\Entity\Category\Attribute\AttributeCollection;
use Tecnogo\MeliSdk\Entity\Category\Attribute\AttributeTag;
use Tecnogo\MeliSdk\Entity\Category\Attribute\AttributeType;
use Tecnogo\MeliSdk\Test\Resource\AbstractResourceTest;
use Tecnogo\MeliSdk\Test\Resource\CreateMapResponseGetRequest;

class GetCategoryAttributesTest extends AbstractResourceTest
{
    use CreateMapResponseGetRequest;

    /**
     * @return array
     */
    public function getCategoryAttributeResources()
    {
        return [
            ['MLA1459', 17],
            ['MLA1467', 56],
            ['MLA1055', 85],
            ['MLA404596', 25],
            ['MLA1652', 69],
        ];
    }

    /**
     * @param Client $client
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     */
    protected function triggerRequestForErrorResponses(Client $client)
    {
        $client->category('wubba_lubba_dub')->attributes();
    }

    /**
     * @dataProvider getCategoryAttributeResources
     * @param $categoryId
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testGetCategoryAttributes($categoryId, $count)
    {
        $client = $this->getClientWithMapGetResponse([
            'categories/' . $categoryId . '/attributes' => [
                200,
                file_get_contents(__DIR__ . '/Fixture/categories_' . $categoryId . '_attributes.json')
            ]
        ]);

        $attributes = $client->category($categoryId)->attributes();

        $this->assertInstanceOf(AttributeCollection::class, $attributes);
        $this->assertCount($count, $attributes);

        $attributes->each(function (Attribute $attribute) {
            $this->validateAttribute($attribute);
        });
    }

    private function validateAttribute(Attribute $attribute)
    {
        $this->assertInstanceOf(Attribute::class, $attribute);

        $this->validateType($attribute);
        $this->validateTags($attribute->tags());
    }

    /**
     * @param Attribute $attribute
     */
    private function validateTags($tags)
    {
        $this->assertIsArray($tags);

        foreach ($tags as $tag => $value) {
            $this->assertTrue(
                AttributeTag::validate($tag),
                "$tag is a valid tag"
            );
        }
    }

    private function validateType(Attribute $attribute)
    {
        $this->assertNotEmpty($attribute->type());
        $this->assertTrue(
            AttributeType::validate($attribute->type()),
            "{$attribute->type()} is a valid attribute"
        );

        $this->assertIsString($attribute->name());
        $this->assertNotEmpty($attribute->name());

        switch ($attribute->type()) {
            case AttributeType::BOOLEAN:
                $this->assertIsArray($attribute->values());
                $this->assertCount(2, $attribute->values());
                break;
            case AttributeType::LIST:
                $this->assertIsArray($attribute->values());
                $this->assertNotEmpty($attribute->values());
                break;
            case AttributeType::NUMBER_UNIT:
                $this->assertIsArray($attribute->allowedUnits());
                $this->assertNotEmpty($attribute->allowedUnits());
                $this->assertNotEmpty($attribute->defaultUnit());
                break;
        }
    }
}
