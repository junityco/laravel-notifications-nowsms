<?php

namespace Junity\Notifications\NowSms;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Support\ServiceProvider;

class NowSmsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
    	$this->app->when(NowSmsChannel::class)
    		->needs(NowSms::class)
    		->give(function () {
    			$config = $this->app['config']['services.nowsms'];

    			return new NowSms(new HttpClient, $config);
    		});
    }
}
