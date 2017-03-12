<?php

namespace Junity\NowSms\Messages;

use Carbon\Carbon;

class SmsMessage
{
	/**
     * The "mode" of the message.
     *
     * @var boolean
     */
    public $flash = false;

	/**
     * The phone number or sender name the message should be sent from.
     *
     * @var string
     */
    public $from;

	/**
     * The message content.
     *
     * @var string
     */
    public $content;

    /**
     * The time when message should be sent.
     *
     * @var \Carbon\Carbon
     */
    public $delay;

    /**
     * Create a new message instance.
     *
     * @param  string  $content
     * @return void
     */
    public function __construct($content = '')
    {
        $this->content = $content;
    }

    /*
     * Indicate that the message must be sent in a default mode.
     *
     * @return $this
     */
    public function default()
    {
        $this->flash = false;
        
        return $this;
    }

    /*
     * Indicate that the message must be sent in a flash mode.
     *
     * @return $this
     */
    public function flash()
    {
        $this->flash = true;

        return $this;
    }

    /**
     * Set the phone number or sender name the message should be sent from.
     *
     * @param  string  $from
     * @return $this
     */
    public function from($from)
    {
        $this->from = $from;
        
        return $this;
    }

    /**
     * Set the message content.
     *
     * @param  string  $content
     * @return $this
     */
    public function content($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Set the time when message should be sent.
     *
     * @param  \Carbon\Carbon  $delay
     * @return $this
     */
    public function delay(Carbon $time)
    {
        $this->delay = $time;

        return $this;
    }

    /**
     * Get array representation of message for NowSMS client.
     *
     * @return array
     */
    public function toArray()
    {
        $payload = [
        	'Text' => $this->content
        ];

        if ($this->flash === true) {
        	$payload['DCS'] = 10;
        }

        if (! is_null($this->from)) {
        	$payload['Sender'] = $this->from;
        }

        if (! is_null($this->delay)) {
        	$payload['DelayUntil'] = $this->delay->format('Y-m-d H:i');
        }

        return $payload;
    }
}
