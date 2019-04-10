<p align="center">
<img src="https://avatars1.githubusercontent.com/u/49149236"/>
</p>

## MeliSdk: El API de Mercadolibre, facil.  

[![Build Status](https://travis-ci.org/tecnogo/meli-sdk.svg?branch=master)](https://travis-ci.org/tecnogo/meli-sdk)  [![License](https://poser.pugx.org/tecnogo/meli-sdk/license)](https://packagist.org/packages/phpunit/phpunit)

### Requerimientos

 * PHP 7.2
 * ext-curl
 * ext-json

### Instalación

`composer require tecnogo/meli-sdk`

### Uso

```php
require __DIR__ . '/vendor/autoload.php';

$client = new \Tecnogo\MeliSdk\Client([
    'app_secret' => 'SOME_APP_SECRET',
    'app_id' => 'SOME_APP_ID',
    'access_token' => 'SOME_ACCESS_TOKEN',
    'redirect_url' => 'http://localhost:8000'
]);

// Obtener bookmarks:

$bookmarks = $client->bookmarks();

$bookmarks->each(function (\Tecnogo\MeliSdk\Entity\LoggedUser\Bookmark $bookmark) {
    $item = $bookmark->item();
    echo $item->title() . "\n";
    echo json_encode($item->attributes()->simplifiedMap());
});
```