<img src="https://avatars1.githubusercontent.com/u/49149236" align="left" width="192px" height="192px"/>
<img align="left" width="0" height="192px" hspace="10"/>

> El API de Mercadolibre, facil. 

[![Build Status](https://travis-ci.org/tecnogo/meli-sdk.svg?branch=master)](https://travis-ci.org/tecnogo/meli-sdk)

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
