HipChat PHP API v2
============================

## Package is unstable. Do not use it in production !

___

HipChat API v2 wrapper for PHP.

Supported HTTP Clients: Guzzle 4.x, Guzzle 3.x, Resty 0.6.x

Frameworks: Native PHP, Laravel 4.1

PHP >= 5.4.x (short array syntax, which will be refactored to support 5.3.x)

**TODO**:

1. Improve PHPDoc blocks
2. Ability to use Addon OAuth ID and Secret
3. Laravel Facades and Configurations
4. Full Documentation
5. Tests
6. ...

___

## Installation

Begin by installing this package through Composer.

```js
{
    "require": {
        "PageBoost/hipchat-php-v2": "dev-master"
    }
}
```

You should have at least one HTTP Client installed. Supported out of box are Guzzle and Resty.

### Http Client

You can use any Http Client which implements `PageBoost\HipChatV2\Contracts\RequestInterface`

#### Example:

```php
// Your Curl Client
class NativeCurlClient implements \PageBoost\HipChatV2\Contracts\RequestInterface {}

// Initiate Your Client
$myHttpClient = new NativeCurlClient();

// Create HipChat instance
$hipchat = new \PageBoost\HipChatV2\HipChat($myHttpClient);
// or
\PageBoost\HipChatV2\HipChatFactory::$httpClient = $myHttpClient;
$hipchat = \PageBoost\HipChatV2\HipChatFactory::instance();
```

### Package API Methods

```php
use PageBoost\HipChatV2\HipChatFactory;
$hipchat = HipChatFactory::instance();

$hipchat->setAccessToken('XXXXXXXX') // Set your OAuth 2 Token

// Rooms
$rspRoomAll = $hipchat->room()->all();
$hipchat->room()->setId('9999');
$rspRoomCreate = $hipchat->room()->create('My new room');
$hipchat->room($rspRoomCreate['id'])->setTopic('First topic');
$hipchat->room($rspRoomCreate['id'])->send('First message to new room');
$hipchat->room($rspRoomCreate['id'])->send('Second message to new room', true, 'red', 'html');
$rspRoomGetOne = $hipchat->room($rspRoomCreate['id'])->get();
$hipchat->room($rspRoomCreate['id'])->delete();
$rspRoomHistory = $hipchat->room($rspRoomCreate['id'])->history();

$rspRoomMembers = $hipchat->room($rspRoomCreate['id'])->allMembers();
$hipchat->room($rspRoomCreate['id'])->addMember($user_id);
$hipchat->room($rspRoomCreate['id'])->deleteMember($user_id);

$hipchat->room($room_id = null)->webhook($hook_id = null)->all(...);
$hipchat->room($room_id = null)->webhook($hook_id = null)->create(...);
$hipchat->room($room_id = null)->webhook($hook_id = null)->get();
$hipchat->room($room_id = null)->webhook($hook_id = null)->delete();

// Users
$hipchat->user($user_id = null)->all(...);
$hipchat->user($user_id = null)->get();
$hipchat->user($user_id = null)->delete();
$hipchat->user($user_id = null)->create(...);
$hipchat->user($user_id = null)->send(...);
$hipchat->user($user_id = null)->update(...);

// A lot more for every API v2 endpoint !
$hipchat->emoticon($emotionc_id = null)->...;
$hipchat->session($session_id = null)->...;

```

### Exceptions

All exceptions extend `PageBoost\HipChatV2\Exceptions\HipChatV2Exception`.

- HTTP Code 400 => `PageBoost\HipChatV2\Exceptions\BadRequestException`
- HTTP Code 401 => `PageBoost\HipChatV2\Exceptions\UnauthorizedException`
- HTTP Code 403 => `PageBoost\HipChatV2\Exceptions\ForbiddenException`
- HTTP Code 404 => `PageBoost\HipChatV2\Exceptions\NotFoundException`
- HTTP Code 500 => `PageBoost\HipChatV2\Exceptions\InternalServerErrorException`
- HTTP Code 503 => `PageBoost\HipChatV2\Exceptions\ServerUnavailableException`
- Default Exception => `PageBoost\HipChatV2\Exceptions\HipChatV2Exception`

Exceptions are mapped to API Response Codes. You can handle them as you want.

### Response

Every method return `PageBoost\HipChatV2\Response` instance.

```php
$hipchatRoom = HipChatFactory::room(100);
$rspRoomGet = $hipchatRoom->get();

print $rspRoomGet->getRateLimit(); // "X-RateLimit-Limit" - http header
print $rspRoomGet->getRateRemaining(); // "X-RateLimit-Remaining" - http header
print $rspRoomGet->getRateReset(); // "X-RateLimit-Reset" - http header
print $rspRoomGet->getResponseCode(); // HTTP Response Code (200, 201, 204, etc)
var_dump($rspRoomGet->getData()); // Return array of returned data from API
```

### Title Expansion

There is support of "[title expansion](https://www.hipchat.com/docs/apiv2/expansion)".

```php
$hipchat->room(100)->expand('owner')->get();
$hipchat->room(100)->expand(array('owner', 'participants'))->get();
```

___

## Native PHP

```php
 // Get general instance
$hipchat = \PageBoost\HipChatV2\HipChatFactory::instance();

// Get Rooms instance
\PageBoost\HipChatV2\HipChatFactory::setAccessToken('XXXXXXXXXXXXX');
$hipchatRooms = \PageBoost\HipChatV2\HipChatFactory::room(); // Without Room ID
$hipchatRooms = \PageBoost\HipChatV2\HipChatFactory::room(10000); // With Room ID
```

## Laravel 

```php
$hipchat = App::make('hipchat-v2');
```

## License

[View the license](https://github.com/PageBoost/hipchat-php-v2/blob/master/LICENSE) for this repo.