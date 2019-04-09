<?php

namespace Tecnogo\MeliSdk\Entity\Category\Attribute;

use Tecnogo\MeliSdk\Client\Factory;
use Tecnogo\MeliSdk\Entity\Category\Exception\InvalidAttributeTypeException;

/**
 * Class AttributeFactory
 *
 * @package Tecnogo\MeliSdk\Entity\Category\Attribute
 *
 * @internal
 */
final class AttributeFactory
{
    /**
     * @var Factory
     */
    private $factory;

    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * @param array $payload
     * @return Attribute
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws InvalidAttributeTypeException
     */
    public function make(array $payload = [])
    {
        return $this->factory->make($this->resolveClass($payload))->hydrate($payload);
    }

    /**
     * @param array $payload
     * @return string
     * @throws InvalidAttributeTypeException
     */
    private function resolveClass(array $payload = [])
    {
        $valueType = $payload['value_type'] ?? null;

        switch ($valueType) {
            case AttributeType::BOOLEAN:
                return BooleanAttribute::class;
            case AttributeType::LIST:
                return ListAttribute::class;
            case AttributeType::NUMBER:
                return  NumberAttribute::class;
            case AttributeType::NUMBER_UNIT:
                return NumberUnitAttribute::class;
            case AttributeType::STRING:
                return StringAttribute::class;
            default:
                throw new InvalidAttributeTypeException($valueType);
        }
    }
}
