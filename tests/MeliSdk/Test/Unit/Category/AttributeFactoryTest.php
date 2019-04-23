<?php

namespace Tecnogo\MeliSdk\Test\Unit\Category;

use PHPUnit\Framework\TestCase;
use Tecnogo\MeliSdk\Client;
use Tecnogo\MeliSdk\Entity\Category\Attribute\Attribute;
use Tecnogo\MeliSdk\Entity\Category\Attribute\AttributeFactory;
use Tecnogo\MeliSdk\Entity\Category\Attribute\AttributeTag;
use Tecnogo\MeliSdk\Entity\Category\Attribute\AttributeType;
use Tecnogo\MeliSdk\Entity\Category\Attribute\BooleanAttribute;
use Tecnogo\MeliSdk\Entity\Category\Attribute\ListAttribute;
use Tecnogo\MeliSdk\Entity\Category\Attribute\NumberAttribute;
use Tecnogo\MeliSdk\Entity\Category\Attribute\NumberUnitAttribute;
use Tecnogo\MeliSdk\Entity\Category\Attribute\StringAttribute;
use Tecnogo\MeliSdk\Entity\Category\Exception\InvalidAttributeTypeException;

class AttributeFactoryTest extends TestCase
{
    /**
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     * @throws InvalidAttributeTypeException
     */
    public function testExpectExceptionForEmptyPayloads()
    {
        $factory = $this->createFactory();

        $this->expectException(InvalidAttributeTypeException::class);
        $factory->make([]);
    }

    /**
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     * @throws InvalidAttributeTypeException
     */
    public function testExpectExceptionForInvalidType()
    {
        $factory = $this->createFactory();

        $this->expectException(InvalidAttributeTypeException::class);
        $factory->make(['value_type' => -1]);
    }

    /**
     * @param string $valueType
     * @param string $expectedClass
     * @dataProvider getAttributeTypeClassMappingData
     * @throws InvalidAttributeTypeException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testAttributeTypeMapping($valueType, $expectedClass)
    {
        $factory = $this->createFactory();

        $attribute = $factory->make(['value_type' => $valueType]);

        $this->assertInstanceOf(Attribute::class, $attribute);
        $this->assertInstanceOf($expectedClass, $attribute);
    }

    /**
     * @throws InvalidAttributeTypeException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testMakeBooleanAttribute()
    {
        $factory = $this->createFactory();

        $attribute = $factory->make([
            'id' => 'IS_DUAL_SIM',
            'name' => 'Es Dual SIM',
            'tags' => [
            ],
            'hierarchy' => 'PARENT_PK',
            'relevance' => 1,
            'value_type' => 'boolean',
            'values' => [
                [
                    'id' => '242084',
                    'name' => 'No',
                    'metadata' => [
                        'value' => false
                    ]
                ],
                [
                    'id' => '242085',
                    'name' => 'Sí',
                    'metadata' => [
                        'value' => true
                    ]
                ]
            ],
            'attribute_group_id' => 'OTHERS',
            'attribute_group_name' => 'Otros'
        ]);

        $this->assertInstanceOf(BooleanAttribute::class, $attribute);
        $this->assertEquals($attribute->id(), 'IS_DUAL_SIM');
        $this->assertEquals($attribute->name(), 'Es Dual SIM');
        $this->assertEquals($attribute->type(), 'boolean');
        $this->assertCount(2, $attribute->values());
        $this->assertFalse($attribute->required());
        $this->assertEmpty($attribute->tags());
    }

    /**
     * @throws InvalidAttributeTypeException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testMakeStringAttribute()
    {
        $factory = $this->createFactory();

        $attribute = $factory->make([
            'id' => 'COLOR',
            'name' => 'Color',
            'tags' => [
                'allow_variations' => true,
                'defines_picture' => true
            ],
            'hierarchy' => 'CHILD_PK',
            'relevance' => 1,
            'value_type' => 'string',
            'value_max_length' => 255,
            'values' => [
                [
                    'id' => '52019',
                    'name' => 'Verde oscuro'
                ],
                [
                    'id' => '52055',
                    'name' => 'Blanco'
                ],
                [
                    'id' => '52001',
                    'name' => 'Beige'
                ],
                [
                    'id' => '51993',
                    'name' => 'Rojo'
                ],
                [
                    'id' => '51996',
                    'name' => 'Terracota'
                ],
                [
                    'id' => '283165',
                    'name' => 'Gris claro'
                ],
                [
                    'id' => '283151',
                    'name' => 'Naranja oscuro'
                ],
                [
                    'id' => '52024',
                    'name' => 'Azul petróleo'
                ]
            ],
            'attribute_group_id' => 'OTHERS',
            'attribute_group_name' => 'Otros'
        ]);

        $this->assertInstanceOf(StringAttribute::class, $attribute);
        $this->assertEquals($attribute->id(), 'COLOR');
        $this->assertEquals($attribute->name(), 'Color');
        $this->assertEquals($attribute->type(), 'string');
        $this->assertCount(8, $attribute->values());
        $this->assertFalse($attribute->required());
        $this->assertNotEmpty($attribute->tags());
        $this->assertTrue($attribute->hasTag(AttributeTag::ALLOW_VARIATIONS));
    }

    /**
     * @throws InvalidAttributeTypeException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testMakeListAttribute()
    {
        $factory = $this->createFactory();

        $attribute = $factory->make([
            'id' => 'ITEM_CONDITION',
            'name' => 'Condición del ítem',
            'tags' => [
                'hidden' => true
            ],
            'hierarchy' => 'ITEM',
            'relevance' => 2,
            'value_type' => 'list',
            'values' => [
                [
                    'id' => '2230284',
                    'name' => 'Nuevo'
                ],
                [
                    'id' => '2230581',
                    'name' => 'Usado'
                ],
                [
                    'id' => '2230582',
                    'name' => 'Reacondicionado'
                ]
            ],
            'attribute_group_id' => 'OTHERS',
            'attribute_group_name' => 'Otros'
        ]);

        $this->assertInstanceOf(ListAttribute::class, $attribute);
        $this->assertEquals($attribute->id(), 'ITEM_CONDITION');
        $this->assertEquals($attribute->name(), 'Condición del ítem');
        $this->assertEquals($attribute->type(), 'list');
        $this->assertCount(3, $attribute->values());
        $this->assertFalse($attribute->required());
        $this->assertNotEmpty($attribute->tags());
        $this->assertFalse($attribute->hasTag(AttributeTag::ALLOW_VARIATIONS));
        $this->assertTrue($attribute->hasTag(AttributeTag::HIDDEN));
    }

    /**
     * @throws InvalidAttributeTypeException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testNumberListAttribute()
    {
        $factory = $this->createFactory();

        $attribute = $factory->make([
            'id' => 'PARKING_LOTS',
            'name' => 'Cocheras',
            'tags' => [
                'catalog_required' => true,
                'required' => true
            ],
            'hierarchy' => 'ITEM',
            'relevance' => 1,
            'value_type' => 'number',
            'value_max_length' => 18,
            'attribute_group_id' => 'FIND',
            'attribute_group_name' => 'Ficha técnica'
        ]);

        $this->assertInstanceOf(NumberAttribute::class, $attribute);
        $this->assertEquals($attribute->id(), 'PARKING_LOTS');
        $this->assertEquals($attribute->name(), 'Cocheras');
        $this->assertEquals($attribute->type(), 'number');
        $this->assertCount(0, $attribute->values());
        $this->assertNotEmpty($attribute->tags());
        $this->assertTrue($attribute->required());
        $this->assertTrue($attribute->hasTag(AttributeTag::CATALOG_REQUIRED));
        $this->assertFalse($attribute->hasTag(AttributeTag::HIDDEN));
    }

    /**
     * @throws InvalidAttributeTypeException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testNumberUnitListAttribute()
    {
        $factory = $this->createFactory();

        $attribute = $factory->make([
            'id' => 'BALCONY_AREA',
            'name' => 'Superficie de balcón',
            'tags' => [
                'hidden' => true
            ],
            'hierarchy' => 'ITEM',
            'relevance' => 1,
            'value_type' => 'number_unit',
            'value_max_length' => 255,
            'allowed_units' => [
                [
                    'id' => 'm²',
                    'name' => 'm²'
                ],
                [
                    'id' => 'in²',
                    'name' => 'in²'
                ],
                [
                    'id' => 'ha',
                    'name' => 'ha'
                ],
                [
                    'id' => 'cm²',
                    'name' => 'cm²'
                ]
            ],
            'default_unit' => 'm²',
            'attribute_group_id' => 'DFLT',
            'attribute_group_name' => 'Otros'
        ]);

        $this->assertInstanceOf(NumberUnitAttribute::class, $attribute);
        $this->assertEquals($attribute->id(), 'BALCONY_AREA');
        $this->assertEquals($attribute->name(), 'Superficie de balcón');
        $this->assertEquals($attribute->type(), 'number_unit');
        $this->assertCount(0, $attribute->values());

        $this->assertNotEmpty($attribute->tags());
        $this->assertFalse($attribute->required());
        $this->assertFalse($attribute->hasTag(AttributeTag::CATALOG_REQUIRED));
        $this->assertTrue($attribute->hasTag(AttributeTag::HIDDEN));

        $this->assertNotNull($attribute->defaultUnit());
        $this->assertEquals($attribute->defaultUnit(), 'm²');
        $this->assertNotEmpty($attribute->allowedUnits());
        $this->assertCount(4, $attribute->allowedUnits());
    }

    /**
     * @return AttributeFactory
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    private function createFactory()
    {
        return (Client::create())->make(AttributeFactory::class);
    }

    /**
     * @return array
     */
    public function getAttributeTypeClassMappingData()
    {
        return [
            [AttributeType::BOOLEAN, BooleanAttribute::class],
            [AttributeType::LIST, ListAttribute::class],
            [AttributeType::NUMBER, NumberAttribute::class],
            [AttributeType::NUMBER_UNIT, NumberUnitAttribute::class],
            [AttributeType::STRING, StringAttribute::class],
        ];
    }
}
