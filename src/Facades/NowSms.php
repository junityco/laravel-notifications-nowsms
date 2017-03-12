<?php

namespace Junity\NowSms\Facades;

use Illuminate\Support\Facades\Facade;
use Junity\NowSms\NowSms as BaseNowSms;

/**
 * @see \Junity\NowSms\NowSms
 */
class NowSms extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return NowSms::class;
    }
}
