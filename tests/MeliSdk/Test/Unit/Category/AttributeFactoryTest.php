<?php

namespace Tecnogo\MeliSdk\Test\Unit\Category;

use PHPUnit\Framework\TestCase;
use Tecnogo\MeliSdk\Client;
use Tecnogo\MeliSdk\Entity\Category\Attribute\Attribute;
use Tecnogo\MeliSdk\Entity\Category\Attribute\AttributeFactory;
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