## MeliSdk: El API de Mercadolibre, facil.  

[![Build Status](https://travis-ci.org/tecnogo/meli-sdk.svg?branch=master)](https://travis-ci.org/tecnogo/meli-sdk)  [![License](https://poser.pugx.org/tecnogo/meli-sdk/license)](https://packagist.org/packages/tecnogo/melisdk)

### Requerimientos

 * PHP 7.2
 * ext-curl
 * ext-json

### Instalación

Dado el estado actual de desarrollo, *requiere* [configurar la estabilidad minima](https://getcomposer.org/doc/04-schema.md#minimum-stability) del proyecto a `dev`.

Importar la libreria utilizando composer:

`composer require tecnogo/meli-sdk`

### Configuración

Si bien ninguna opción es obligatoria, el acceso a ciertas APIs puede requerir ciertos parametros (app_id, app_secret
y/o access_token).

Para generar una aplicación de Mercadolibre ingresa a: [Crear nueva aplicación](https://developers.mercadolibre.com.ar/apps/create-app)

| Opción | Descripción |
| --- | --- |
| site_id | Id de sitio de Mercadolibre, por defecto MLA |
| app_id | App id de la aplicación de Mercadolibre |
| app_secret | App secret de la aplicación de Mercadolibre |
| redirect_url | Url de redirección de autorización de usuario, debe coincidir con la url definida en la aplicación de Mercadolibre |
| access_token | Access token del usuario loggeado |
| api_url | Url base del API, por defecto https://api.mercadolibre.com/ |

### Uso

```php
require __DIR__ . '/vendor/autoload.php';

$client = \Tecnogo\MeliSdk\Client::create([
    'app_secret' => 'SOME_APP_SECRET',
    'app_id' => 'SOME_APP_ID',
    'access_token' => 'SOME_ACCESS_TOKEN',
    'redirect_url' => 'http://localhost:8000'
]);

// Obtener bookmarks (requiere access_token)

$bookmarks = $client->bookmarks();

$bookmarks->each(function (\Tecnogo\MeliSdk\Entity\LoggedUser\Bookmark $bookmark) {
    $item = $bookmark->item();
    echo $item->title() . "\n";
    echo json_encode($item->attributes()->simplifiedMap());
});
```

### Ejemplos

 * [Laravel: Listado de publicaciones de usuario](https://github.com/tecnogo/meli-examples-my-items)
 * [Lumen: Predicción de categoría de item](https://github.com/tecnogo/meli-examples-category-prediction)
 * [Symfony4: Generación de formularios de atributos](https://github.com/tecnogo/meli-examples-category-attr-form)


### Licencia

© 2019 Valentin Starck <valentin.starck@gmail.com>

Este proyecto está bajo licencia MIT. Para más información: [LICENSE](https://raw.githubusercontent.com/tecnogo/meli-sdk/master/LICENSE)
