<?php
namespace PageBoost\HipChatV2\Exceptions;

use Exception;

class HipChatV2Exception extends Exception
{
    protected $url;

    public function __construct($msg, $code, $url = '')
    {
        $this->url =  $url;
        parent::__construct($msg, (int)$code);
    }

    public function getUrl()
    {
        return $this->url;
    }
}
