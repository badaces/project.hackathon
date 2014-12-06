<?php

namespace App\Web\API\Consumer;

use App\Web\API\Exception\FailedRequestException;
use Guzzle\Http\Message\RequestInterface;
use Guzzle\Http\Message\Response;
use igorw\FailingTooHardException;

abstract class AbstractConsumer
{
    /**
     * @var int
     */
    protected $retryCount = 10;

    /**
     * @param RequestInterface $request
     * @param bool $expectsResponseData
     * @return Response
     * @throws FailedRequestException
     */
    public function sendRequest(RequestInterface $request, $expectsResponseData = true)
    {
        try {
            return \igorw\retry($this->retryCount, function () use ($request, $expectsResponseData) {
                $result = $request->send();

                if ($result->isSuccessful() && (!$expectsResponseData || $result->getContentLength() > 0)) {
                    return $result;
                }

                usleep(500000); // Half second sleep
                throw new \Exception();
            });
        } catch(FailingTooHardException $e) {
            throw new FailedRequestException();
        }
    }
}
