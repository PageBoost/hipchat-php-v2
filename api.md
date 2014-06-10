---
layout: default
title: API
type: api

---

### <a href="api.html#auth" name="auth">#</a> Authentication

You need a valid token to use HipChat API.

```php
$hipchat->setAccessToken('XXXXXXXX'); // Set your OAuth 2 Token
print $hipchat->getAccessToken(); // Get current OAuth 2 Token
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

```php
/* Longer Initialization */
$emoticonsApi = $hipchat->emoticon(); // Get Emoticon Resource
$emoticonsApi->setId($emoticon_id); // Set Emoticon ID or shortcode

/* Shorter Initialization */
$hipchat->emoticon($emoticon_id); // easier way

/* Working with Emoticons */
$hipchat->emoticon()->all($startIndex = 0, $maxResult = 100, $type = 'all'); // Get All Emoticon
$hipchat->emoticon($emoticon_id)->get(); // Get Emoticons
```

### <a href="api.html#sessions" name="sessions">#</a> OAuth Sessions

```php
/* Longer Initialization */
$sessionAPI = $hipchat->session(); // Get Session Resource
$sessionAPI->setId($session_id); // Set OAuth Token

/* Shorter Initialization */
$hipchat->session($session_id); // easier way

/* Working with Sessions */
$hipchat->session($session_id)->get(); // Get Session
$hipchat->session($session_id)->delete(); // Delete Session
$hipchat->session()->create($grant_type, $_options = array()); // Create session with personal token
$hipchat->session()->createOAuth($oauthId, $secret, $grant_type, $_options = array()); // Create session with Addon Credentials
```

### <a href="api.html#rooms" name="rooms">#</a> Rooms

```php
/* Longer Initialization */
$roomApi = $hipchat->room(); // Get Room Resource
$roomApi->setId($room_id); // Set Room ID

/* Shorter Initialization */
$hipchat->room($room_id); // easier way

/* Working with Rooms */
$hipchat->room()->all($startIndex = 0, $maxResult = 100); // Get All Rooms
$hipchat->room($room_id)->get(); // Get Room
$hipchat->room($room_id)->delete(); // Delete Room
$hipchat->room()->create($name, $is_public = true, $guest_access = false, $owner_user_id = null); // Create Room
$hipchat->room($room_id)->update($name, $is_public, $is_archived, $is_guest_accessible, $topic, $owner_user_id); // Update Room
$hipchat->room($room_id)->setTopic($topic); // Set Room Topic
$hipchat->room($room_id)->send($message, $notify = false, $color = HipChat::COLOR_YELLOW, $message_format = HipChat::FORMAT_HTML); // Send Room Message
$hipchat->room($room_id)->history($startIndex = 0, $maxResult = 100); // Get Room History
$hipchat->room($room_id)->getEmbeddingUrl($minimal = 1, $anonymous = 0, $timezone = 'UTC', $welcome_msg = ''); // Return embeddable url to Guest Rooms or return NULL if room is not public! Useful for iframe integrations.
```

### <a href="api.html#rooms_webhooks" name="rooms_webhooks">#</a> Rooms Webhooks

```php
/* Longer Initialization */
$roomWebhookApi = $hipchat->room($room_id)->webhook(); // Get Webhook Resource
$roomWebhookApi->setId($webhook_id); // Set Webhook ID

/* Shorter Initialization */
$hipchat->room($room_id)->webhook($webhook_id); // easier way

/* Working with Rooms Webhooks */
$hipchat->room($room_id)->webhook()->all($startIndex = 0, $maxResult = 100); // Get All Room's Webhooks
$hipchat->room($room_id)->webhook($webhook_id)->get(); // Get Room's Webhook
$hipchat->room($room_id)->webhook($webhook_id)->delete(); // Delete Room's Webhook
$hipchat->room($room_id)->webhook()->create($url, $event, $pattern = '', $name = ''); // Create Room's Webhook
```

### <a href="api.html#rooms_members" name="rooms_members">#</a> Rooms Members

```php
$hipchat->room($room)id)->addMember($user_id); // Add Member to private room
$hipchat->room($room)id)->deleteMember($user_id); // Remove Member from private room
$hipchat->room($room_id)->allMembers($startIndex = 0, $maxResult = 100); // Gets all Members for privater oom
```

### <a href="api.html#users" name="users">#</a> Users

```php
/* Longer Initialization */
$userApi = $hipchat->user(); // Get User Resource
$userApi->setId($user_id); // Set User ID

/* Shorter Initialization */
$hipchat->user($user_id); // easier way

/* Working with Users */
$hipchat->user()->all($include_guests = false, $include_deleted = false, $startIndex = 0, $maxResult = 100); // Get All Users
$hipchat->user($user_id)->get(); // Get User
$hipchat->user($user_id)->delete(); // Delete User
$hipchat->user()->create($name, $email, $_options = array()); // Create User
$hipchat->user($user_id)->update($name, $email, $mention_name, $timezone = 'UTC', $is_group_admin = false, $title = '', $password = null); // Update User. BE VERY CAREFUL !! All fields except `password` are required and need to be resend even if they are not changes. I lost my admin permissions first time :)
$hipchat->user($user_id)->send($message); // Send private message. Plain text only.
$hipchat->user($user_id)->uploadPhoto($raw_photo_content); // Update User's avatar. Pass photo content e.g. fread($handle, filesize($filename));
$hipchat->user($user_id)->deletePhoto(); // Remove User's avatar
```
