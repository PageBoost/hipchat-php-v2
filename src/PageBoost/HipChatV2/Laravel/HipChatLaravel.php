<?php namespace PageBoost\HipChatV2\Laravel;

use PageBoost\HipChatV2\HipChat;

class HipChatLaravel extends HipChat
{
    protected $defaultOauthId = null;

    protected $defaultOauthSecret = null;

    public function generateToken($grant_type, $_options = array())
    {
        return $this->session()->createOAuth($this->getDefaultOauthId(), $this->getDefaultOauthSecret(), $grant_type, $_options = array());
    }

    /**
     * @param null $defaultOauthId
     */
    public function setDefaultOauthId($defaultOauthId)
    {
        $this->defaultOauthId = $defaultOauthId;
    }

    /**
     * @return null
     */
    public function getDefaultOauthId()
    {
        return $this->defaultOauthId;
    }

    /**
     * @param null $defaultOauthSecret
     */
    public function setDefaultOauthSecret($defaultOauthSecret)
    {
        $this->defaultOauthSecret = $defaultOauthSecret;
    }

    /**
     * @return null
     */
    public function getDefaultOauthSecret()
    {
        return $this->defaultOauthSecret;
    }
}
