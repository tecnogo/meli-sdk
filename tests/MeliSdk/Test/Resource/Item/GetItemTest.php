<?php

namespace Tecnogo\MeliSdk\Test\Resource\Item;

use Tecnogo\MeliSdk\Client;
use Tecnogo\MeliSdk\Entity\Category\Category;
use Tecnogo\MeliSdk\Entity\Item\Attribute;
use Tecnogo\MeliSdk\Entity\Item\AttributeCollection;
use Tecnogo\MeliSdk\Entity\Item\Item;
use Tecnogo\MeliSdk\Test\Resource\AbstractResourceTest;
use Tecnogo\MeliSdk\Test\Resource\CreateCallbackResponseGetRequest;
use Tecnogo\MeliSdk\Test\Resource\CreateMapResponseGetRequest;

class GetItemTest extends AbstractResourceTest
{
    use CreateMapResponseGetRequest;
    use CreateCallbackResponseGetRequest;

    /**
     * @param Client $client
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     */
    protected function triggerRequestForErrorResponses(Client $client)
    {
        // We need to use any "getter" method to trigger the lazy loading
        $client->item('MLA769861704')->raw();
    }

    /**
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testCreationWithIdDoesNotTriggerRequest()
    {
        $client = $this->getClientWithCallbackGetResponse(function () {
            throw new \Exception('request_triggered');
        });

        $item = $client->item('MLA111111112');

        $this->assertEquals($item->id(), 'MLA111111112');

        $this->expectExceptionMessage('request_triggered');
        $item->raw();
    }

    /**
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testGetItem()
    {
        $client = $this->getClientWithFixedGetResponse(
            200,
            file_get_contents(__DIR__ . '/Fixture/item_MLA111111111.json')
        );

        $item = $client->item('MLA111111111');

        $this->assertInstanceOf(Item::class, $item);
        $this->assertEquals($item->id(), 'MLA111111111');
        $this->assertEquals($item->title(), 'Casa En Venta En Springfield Calle Falsa 123');
        $this->assertEquals($item->price(), 15000);
        $this->assertEquals(
            $item->permalink(),
            'https://casa.mercadolibre.com.ar/MLA-111111111-casa-en-venta-en-springfield-calle-falsa-123-_JM'
        );
    }

    /**
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testGetItemAttributes()
    {
        $client = $this->getClientWithFixedGetResponse(
            200,
            file_get_contents(__DIR__ . '/Fixture/item_MLA111111111.json')
        );

        $this->clearCache($client);

        $attributes = $client->item('MLA111111111')->attributes();

        $this->assertInstanceOf(AttributeCollection::class, $attributes);
        $this->assertCount(38, $attributes);
        $this->assertInstanceOf(Attribute::class, $attributes->first());
        $this->assertEquals($attributes[0], $attributes->first());
        $this->assertEquals($attributes->first()->name(), 'Altillo');
        $this->assertEquals($attributes->first()->valueName(), 'No');
        $this->assertEquals($attributes->first()->id(), 'HAS_ATTIC');
        $this->assertTrue($attributes->hasAttribute('HAS_ATTIC'));
        $this->assertFalse($attributes->hasAttribute('WUBBA_LUBBA_DUB'));

        $this->assertEquals([
            'Ambientes' => [
                'Altillo' => 'No',
                'Balcón' => 'No',
                'Comedor' => 'Sí',
                'Vestidor' => 'No',
                'Jardín' => 'Sí',
                'Parrilla' => 'No',
                'Toilette' => 'No',
                'Cocina' => 'Sí',
                'Living' => 'Sí',
                'Dependencia de servicio' => 'No',
                'Patio' => 'Sí',
                'Playroom' => 'No',
                'Estudio' => 'No',
                'Terraza' => 'No',
            ],
            'Características adicionales' => [
                'Amoblado' => 'No',
                'Alarma' => 'No',
                'Línea telefónica' => 'Sí',
                'Apto profesional' => 'Sí'
            ],
            'Comodidades y amenities' => [
                'Aire acondicionado' => 'No',
                'Calefacción' => 'No',
                'Acceso a internet' => 'No',
                'Seguridad' => 'No',
                'Pileta' => 'No',
            ],
            'Ficha técnica' => [
                'Dormitorios' => 2,
                'Superficie cubierta' => '133 m²',
                'Pisos' => 0,
                'Baños' => 1,
                'Expensas' => '0 ARS',
                'Cocheras' => 1,
                'Antigüedad' => '35 años',
                'Ambientes' => 3,
                'Superficie total' => '500 m²',
            ],
            'Principales' => [
                'Operación' => 'Alquiler',
                'Inmueble' => 'Casa'
            ],
            'Otros' => [
                'TV por cable' => 'No',
                'Jacuzzi' => 'No',
                'Lavadero' => 'Sí',
                'Condición del ítem' => 'Usado'
            ]
        ], $attributes->simplifiedMap());
    }

    /**
     * @throws \Psr\SimpleCache\InvalidArgumentException
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     * @throws \Tecnogo\MeliSdk\Request\Exception\BadRequestException
     * @throws \Tecnogo\MeliSdk\Request\Exception\ForbiddenResourceException
     * @throws \Tecnogo\MeliSdk\Request\Exception\InvalidTokenException
     * @throws \Tecnogo\MeliSdk\Request\Exception\NotFoundException
     * @throws \Tecnogo\MeliSdk\Request\Exception\RequestException
     * @throws \Tecnogo\MeliSdk\Request\Exception\UnexpectedHttpResponseCodeException
     * @throws \Tecnogo\MeliSdk\Request\Exception\UnknownHttpMethodException
     * @throws \Tecnogo\MeliSdk\Site\Exception\InvalidSiteIdException
     */
    public function testItemCategory()
    {
        $client = $this->getClientWithMapGetResponse([
            'items/MLA111111111' => [200, file_get_contents(__DIR__ . '/Fixture/item_MLA111111111.json')],
            'categories/MLA1467' => [200, file_get_contents(__DIR__ . '/Fixture/categories_MLA1467.json')],
        ]);

        $this->clearCache($client);

        $item = $client->item('MLA111111111');

        $this->assertInstanceOf(Category::class, $item->category());
        $this->assertEquals($item->category()->id(), 'MLA1467');
        $this->assertEquals($item->category()->name(), 'Alquiler');
    }
    /**
     * @param Client $client
     * @throws \Tecnogo\MeliSdk\Exception\ContainerException
     * @throws \Tecnogo\MeliSdk\Exception\MissingConfigurationException
     */
    protected function clearCache(Client $client)
    {
        $client
            ->make(\Tecnogo\MeliSdk\Entity\Item\Api\GetRawItem::class, ['id' => -1])
            ->cache()
            ->clear();
    }
}
