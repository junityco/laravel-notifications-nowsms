<?php

namespace Junity\NowSms\Channel;

use GuzzleHttp\Client as HttpClient;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Notifications\Events\NotificationFailed;

class NowSmsChannel extends ServiceProvider
{
	/**
     * The NowSMS instance.
     *
     * @var NowSms
     */
    protected $nowsms;

    /**
     * The Dispatcher instance.
     *
     * @var \Illuminate\Contracts\Events\Dispatcher
     */
    protected $events;

    /**
     * Create a new NowSMS channel instance.
     *
     * @param  \GuzzleHttp\Client  $http
     * @return void
     */
    public function __construct(NowSms $nowsms, Dispatcher $events)
    {
        $this->nowsms = $nowsms;
        $this->events = $events;
    }

    /**
     * Send the given notification.
     *
     * @param  mixed  $notifiable
     * @param  \Illuminate\Notifications\Notification  $notification
     *
     * @throws \Junity\Notifications\NowSms\Exceptions\CouldNotSendNotification
     */
    public function send($notifiable, Notification $notification)
    {
    	if (! $receiver = $this->getReceiver($notifiable)) {
    		return;
    	}

    	$message = $notification->toNowSms($notifiable);

    	try {
    		$this->nowsms->send($message, $receiver);
    	} catch (Exception $exception) {
            $this->events->fire(
                new NotificationFailed($notifiable, $notification, 'nowsms', ['message' => $exception->getMessage()])
            );
        }
    }

    /**
     * Get the phone number to send a notification to.
     *
     * @param  mixed  $notifiable
     * @return mixed
     */
    protected function getReceiver($notifiable)
    {
    	if ($notifiable->routeNotificationFor('nowsms')) {
            return $notifiable->routeNotificationFor('nowsms');
        }

        if (isset($notifiable->phone_number)) {
            return $notifiable->phone_number;
        }

        return null;
    }
}
