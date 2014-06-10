<?php
namespace PageBoost\HipChatV2;

use PageBoost\HipChatV2\Exceptions\HipChatV2Exception;

class HipChatFactory
{
    public static $httpClient = null;

    public static $baseUrl = HipChat::BASE_URL;

    public static function instance()
    {
        $http_client = self::createHttpClient();
        return new HipChat($http_client);
    }

    public static function emoticon($id_or_shortcode = null)
    {
        $http_client = self::createHttpClient();
        return new \PageBoost\HipChatV2\Resources\Emoticons($id_or_shortcode, $http_client);
    }

    public static function session($session_id = null)
    {
        $http_client = self::createHttpClient();
        return new \PageBoost\HipChatV2\Resources\Sessions($session_id, $http_client);
    }

    public static function room($room_id = null)
    {
        $http_client = self::createHttpClient();
        return new \PageBoost\HipChatV2\Resources\Rooms($room_id, $http_client);
    }

    public static function user($user_id = null)
    {
        $http_client = self::createHttpClient();
        return new \PageBoost\HipChatV2\Resources\Users($user_id, $http_client);
    }

    public static function webhook($room_id, $hook_id = null)
    {
        $http_client = self::createHttpClient();
        return new \PageBoost\HipChatV2\Resources\Webhooks($room_id, $hook_id, $http_client);
    }

    public static function setAccessToken($accessToken)
    {
        $http_client = self::createHttpClient();
        $http_client->setAccessToken($accessToken);
    }

    public static function createHttpClient()
    {
        if (self::$httpClient !== null) {
            return self::$httpClient;
        }

        if (class_exists('GuzzleHttp\Client')) {
            self::$httpClient = new \PageBoost\HipChatV2\HttpClients\GuzzleV4(self::$baseUrl);
        } elseif (class_exists('Guzzle\Http\Client')) {
            self::$httpClient = new \PageBoost\HipChatV2\HttpClients\GuzzleV3(self::$baseUrl);
        } elseif (class_exists('Resty\Resty')) {
            self::$httpClient = new \PageBoost\HipChatV2\HttpClients\RestyClient(self::$baseUrl);
//        } elseif (extension_loaded('curl')) {
//            self::$httpClient = new \PageBoost\HipChatV2\HttpClients\CurlClient(self::$baseUrl);
        } else {
            throw new HipChatV2Exception('There is no supported HTTP Client!', 999);
        }

        return self::$httpClient;
    }
}
