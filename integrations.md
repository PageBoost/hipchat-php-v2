---
layout: default
title: Integrations
type: integrations

---

### <a href="integrations.html#installation" name="installation">#</a> Installation

Begin by installing this package through Composer.

```js
{
    "require": {
        "PageBoost/hipchat-php-v2": "dev-master"
    }
}
```

You should have at least one HTTP Client installed.
Supported out of box are Guzzle 4.x, Guzzle 3.x and Resty 0.6.x.

```js
{
    "require": {
        "guzzlehttp/guzzle": "~4.0", // OR
        "guzzle/guzzle":"~3.0", // OR
        "resty/resty": "@stable" // OR
    }
}
```

### <a href="integrations.html#httpclient" name="httpclient">#</a> HTTP Client

You can use any Http Client which implements [`PageBoost\HipChatV2\Contracts\RequestInterface`](https://github.com/PageBoost/hipchat-php-v2/blob/master/src/PageBoost/HipChatV2/Contracts/RequestInterface.php)

#### Example:

```php
// Your Curl Client
class NativeCurlClient implements \PageBoost\HipChatV2\Contracts\RequestInterface { ... }

// Initiate Your Client
$myHttpClient = new NativeCurlClient();

// Create HipChat instance
$hipchat = new \PageBoost\HipChatV2\HipChat($myHttpClient);
// or
\PageBoost\HipChatV2\HipChatFactory::$httpClient = $myHttpClient;
$hipchat = \PageBoost\HipChatV2\HipChatFactory::instance();
```

### <a href="integrations.html#vanilla_php" name="vanilla_php">#</a> Vanilla PHP

#### With Composer Autoloader

```php
use PageBoost\HipChatV2\HipChatFactory;

 // Get general instance
$hipchat = HipChatFactory::instance();
$hipchat->setAccessToken('XXXXXXXXXXXXX');

// Static
HipChatFactory::setAccessToken('XXXXXXXXXXXXX');
$hipchatRooms = HipChatFactory::room(); // Without Room ID
$hipchatRooms = HipChatFactory::room(10000); // With Room ID
```

#### Without Composer

...

### <a href="integrations.html#laravel" name="laravel">#</a> Laravel

- **Load Service Provider and Facades** in `app/config/app.php`

```php
// Provider
'providers' => array(
    'PageBoost\HipChatV2\Laravel\HipChatServiceProvider',
)
// Facade
'aliases' => array(
    'HipChat'            => 'PageBoost\HipChatV2\Laravel\Facades\HipChat',
    'HipChatRoom'        => 'PageBoost\HipChatV2\Laravel\Facades\HipChatRoom',
    'HipChatEmoticon'    => 'PageBoost\HipChatV2\Laravel\Facades\HipChatEmoticon',
    'HipChatSession'     => 'PageBoost\HipChatV2\Laravel\Facades\HipChatSession',
    'HipChatUser'        => 'PageBoost\HipChatV2\Laravel\Facades\HipChatUser',
)
```
Only HipChat Facade is really required if you use facades :smile:

- **Publish Configs**

```bash
php artisan config:publish page-boost/hipchat-php-v2
```

- **Edit config file** if you need `app/config/packages/page-boost/hipchat-php-v2/config.php`.

All options are optional and loaded in Service Provider if exists. You can set OAuth Token and Add-on Credentials in your code or own Service Provider.

- **Usage:**

```php
$hipchat = App::make('hipchat-v2'); // Resolve from IoC Container

HipChat::setAccessToken('XXXXXXXXXX'); // Set Access Token on the fly

HipChat::room('YYYYYY')->send('Test msg'); // Send msg in room
HipChatRoom::setId('YYYYYY')->send('Test msg'): // Send msg in room with shortcut facade

```
