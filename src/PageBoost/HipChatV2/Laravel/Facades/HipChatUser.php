<?php
namespace PageBoost\HipChatV2\Laravel\Facades;

use Illuminate\Support\Facades\Facade;

class HipChatUser extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'hipchat-v2.users';
    }
}