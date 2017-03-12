<?php

namespace Junity\NowSms\Facades;

use Junity\NowSms\NowSms;
use Illuminate\Support\Facades\Facade;

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
