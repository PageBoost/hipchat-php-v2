<?php
namespace PageBoost\HipChatV2\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

class HipChatRoom extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'hipchat-v2.rooms';
    }
}