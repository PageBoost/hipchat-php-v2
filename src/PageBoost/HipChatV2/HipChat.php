<?php
namespace PageBoost\HipChatV2;

use PageBoost\HipChatV2\Contracts\RequestInterface;
use PageBoost\HipChatV2\Contracts\ResponseInterface;

class HipChat
{
    const BASE_URL = 'https://api.hipchat.com';
    const API_VERSION = 'v2';

    /**
     * Colors for rooms/message
     */
    const COLOR_YELLOW = 'yellow';
    const COLOR_RED = 'red';
    const COLOR_GRAY = 'gray';
    const COLOR_GREEN = 'green';
    const COLOR_PURPLE = 'purple';
    const COLOR_RANDOM = 'random';

    /**
     * Formats for rooms/message
     */
    const FORMAT_HTML = 'html';
    const FORMAT_TEXT = 'text';

    protected $request = null;

    protected $emoticonResources;

    public function __construct(
        RequestInterface $request,
        $emoticonResources = null,
        $sessionResources = null,
        $roomResources = null,
        $userResources = null
    ) {
        $this->request = $request;
        $this->emoticonResources = $emoticonResources ?:  new \PageBoost\HipChatV2\Resources\Emoticons(null, $this->request);
        $this->sessionResources = $sessionResources ?:  new \PageBoost\HipChatV2\Resources\Sessions(null, $this->request);
        $this->roomResources = $roomResources ?:  new \PageBoost\HipChatV2\Resources\Rooms(null, $this->request);
        $this->userResources = $userResources ?:  new \PageBoost\HipChatV2\Resources\Users(null, $this->request);
    }

    public function emoticon($id_or_shortcode = null)
    {
        $this->emoticonResources->setId($id_or_shortcode);
        return $this->emoticonResources;
    }

    public function session($session_id = null)
    {
        $this->sessionResources->setId($session_id);
        return $this->sessionResources;
    }

    public function room($room_id = null)
    {
        $this->roomResources->setId($room_id);
        return $this->roomResources;
    }

    public function user($user_id = null)
    {
        $this->userResources->setId($user_id);
        return $this->userResources;
    }

    /**
     * @param string $access_token
     */
    public function setAccessToken($access_token)
    {
        $this->request->setAccessToken($access_token);
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->request->getAccessToken();
    }

    public static function throwException($code, $msg)
    {
        switch($code) {
            case 400:
                throw new \PageBoost\HipChatV2\Exceptions\BadRequestException($msg, $code);
                break;
            case 401:
                throw new \PageBoost\HipChatV2\Exceptions\UnauthorizedException($msg, $code);
                break;
            case 403:
                throw new \PageBoost\HipChatV2\Exceptions\ForbiddenException($msg, $code);
                break;
            case 404:
                throw new \PageBoost\HipChatV2\Exceptions\NotFoundException($msg, $code);
                break;
            case 500:
                throw new \PageBoost\HipChatV2\Exceptions\InternalServerErrorException($msg, $code);
                break;
            case 503:
                throw new \PageBoost\HipChatV2\Exceptions\ServerUnavailableException($msg, $code);
                break;
            default:
                throw new \PageBoost\HipChatV2\Exceptions\HipChatV2Exception($msg, $code);
        }
    }
}
