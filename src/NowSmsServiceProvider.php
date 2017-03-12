<?php

namespace Junity\Notifications\NowSms;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Support\ServiceProvider;

class NowSmsServiceProvider extends ServiceProvider
{
    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(NowSms::class, function () {
            $config = $this->app['config']['services.nowsms'];

            return new NowSms(new HttpClient, $config);
        });
    }
}
