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

```php
 // Get general instance
$hipchat = \PageBoost\HipChatV2\HipChatFactory::instance();

// Get Rooms instance
\PageBoost\HipChatV2\HipChatFactory::setAccessToken('XXXXXXXXXXXXX');
$hipchatRooms = \PageBoost\HipChatV2\HipChatFactory::room(); // Without Room ID
$hipchatRooms = \PageBoost\HipChatV2\HipChatFactory::room(10000); // With Room ID
```

### <a href="integrations.html#laravel" name="laravel">#</a> Laravel

```php
$hipchat = App::make('hipchat-v2');
```
