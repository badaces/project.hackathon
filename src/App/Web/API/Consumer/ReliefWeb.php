<?php

namespace App\Web\API\Consumer;

use CBC\Utility\Configuration;
use Guzzle\Http\Client;

class ReliefWeb
{
    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var Client
     */
    private $client;

    public function __construct(Configuration $configuration, Client $client)
    {
        $this->apiKey = $configuration->get('api.keys.mashape');
        $this->client = $client;
    }
}
