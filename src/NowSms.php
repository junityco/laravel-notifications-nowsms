<?php

namespace Junity\NowSms;

use Exception;
use GuzzleHttp\Client as HttpClient;
use Junity\NowSms\Messages\SmsMessage;
use GuzzleHttp\Exception\RequestException;
use Junity\Notifications\NowSms\Exceptions\CouldNotSendNotification;

class NowSms
{
    /**
     * The HTTP client instance.
     *
     * @var \GuzzleHttp\Client
     */
    protected $http;

    /**
     * Config for the NowSMS service.
     *
     * @var array
     */
    protected $config;

    /**
     * Create a new NowSMS channel instance.
     *
     * @param  \GuzzleHttp\Client  $http
     * @return void
     */
    public function __construct(HttpClient $http, array $config = [])
    {
        $this->http = $http;
        $this->config = $config;
    }

    /**
     * Send NowSMS message.
     *
     * @param  mixed  $message
     * @param  string  $receiver
     * @return \Psr\Http\Message\ResponseInterface
     * @throws CouldNotSendNotification
     */
    public function send($message, $receiver)
    {
        if (is_string($message)) {
            $message = new SmsMessage($message);
        }
        
        try {
            return $this->http->post($this->getUrl(), [
                'auth' => $this->getAuthParams(),
                'form_params' => array_merge($message->toArray(), [
                    'Phone' => $receiver
                ])
            ]);
        } catch (RequestException $exception) {
            if ($exception->getResponse()) {
                throw CouldNotSendNotification::serviceRespondedWithAnError($exception->getResponse());
            }

            throw CouldNotSendNotification::communicationFailed($exception);
        } catch (Exception $exception) {
            throw CouldNotSendNotification::communicationFailed($exception);
        }
    }

    /**
     * Get URL of the NowSMS server.
     *
     * @return string|null
     */
    public function getUrl()
    {
        return $this->config['url'];
    }   

    /**
     * Get authorization parameters for the NowSMS server.
     *
     * @return array
     */
    public function getAuthParams()
    {
        $user = $this->config['username'];
        $password = $this->config['password'];

        return [$user, $password];
    }
}
