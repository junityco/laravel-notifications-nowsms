<?php

namespace Junity\NowSms\Exceptions;

use Exception;
use Psr\Http\Message\ResponseInterface;

class CouldNotSendNotification extends Exception
{
    /**
     * @param  \Psr\Http\Message\ResponseInterface  $response
     * @return static
     */
	public static function serviceRespondedWithAnError(ResponseInterface $response)
    {
        $code = $response->getStatusCode();
        $message = $response->getBody();

        return new static("NowSMS responded with an error `{$code} - {$message}`");
    }

    /**
     * @param  \Exception  $exception
     * @return static
     */
    public static function communicationFailed(Exception $exception)
    {
        return new static("The communication with NowSMS failed because `{$exception->getCode()} - {$exception->getMessage()}`");
    }
}
