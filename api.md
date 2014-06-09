---
layout: default
title: API
type: api

---

### <a href="api.html#auth" name="auth">#</a> Authentication

You need a valid token to use HipChat API.

```php
$hipchat->setAccessToken('XXXXXXXX') // Set your OAuth 2 Token
```

If you have an Add-On, you could [Generate Token](https://www.hipchat.com/docs/apiv2/method/generate_token)

```php
$tokenResponse = $hipchat->session()->createOAuth('OAuth ID', 'Secret', 'client_credentials', array(
    'scope' => 'send_message admin_room send_notification view_group',
)); // Vary
```

### <a href="api.html#response" name="response">#</a> Response

All API Responses return `PageBoost\HipChatV2\Response` object.

```php
print $response->getRateLimit(); // "X-RateLimit-Limit" - http header
print $response->getRateRemaining(); // "X-RateLimit-Remaining" - http header
print $response->getRateReset(); // "X-RateLimit-Reset" - http header
print $response->getResponseCode(); // HTTP Response Code (200, 201, 204, etc)
var_dump($response->getData()); // Return array of returned data from API
```

### <a href="api.html#exceptions" name="exceptions">#</a> Exceptions

All exceptions extend `PageBoost\HipChatV2\Exceptions\HipChatV2Exception`.

- HTTP Code 400 => `PageBoost\HipChatV2\Exceptions\BadRequestException`
- HTTP Code 401 => `PageBoost\HipChatV2\Exceptions\UnauthorizedException`
- HTTP Code 403 => `PageBoost\HipChatV2\Exceptions\ForbiddenException`
- HTTP Code 404 => `PageBoost\HipChatV2\Exceptions\NotFoundException`
- HTTP Code 500 => `PageBoost\HipChatV2\Exceptions\InternalServerErrorException`
- HTTP Code 503 => `PageBoost\HipChatV2\Exceptions\ServerUnavailableException`
- Default Exception => `PageBoost\HipChatV2\Exceptions\HipChatV2Exception`

Exceptions are mapped to API Response Codes. You can handle them as you want.

### <a href="api.html#expansion" name="expansion">#</a> Title Expansion

There is support of "[title expansion](https://www.hipchat.com/docs/apiv2/expansion)".

```php
$hipchat->room(100)->expand('owner')->get();
$hipchat->room(100)->expand(array('owner', 'participants'))->get();
```

### <a href="api.html#emoticons" name="emoticons">#</a> Emoticons

### <a href="api.html#sessions" name="sessions">#</a> OAuth Sessions

### <a href="api.html#rooms" name="rooms">#</a> Rooms

### <a href="api.html#rooms_webhooks" name="rooms_webhooks">#</a> Rooms Webhooks

### <a href="api.html#rooms_members" name="rooms_members">#</a> Rooms Members

### <a href="api.html#users" name="users">#</a> Users
