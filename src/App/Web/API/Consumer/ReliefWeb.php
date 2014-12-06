<?php

namespace App\Web\API\Consumer;

use CBC\Utility\Configuration;
use Guzzle\Http\Client;

class ReliefWeb extends AbstractConsumer
{
    /**
     * @var string
     */
    private $apiKey;

    /**
     * @var string
     */
    private $baseUrl = 'https://community-relief-web.p.mashape.com';

    /**
     * @var Client
     */
    private $client;

    public function __construct(Configuration $configuration, Client $client)
    {
        $this->apiKey = $configuration->get('api.keys.mashape');
        $this->client = $client;
    }

    public function getCountries()
    {
        $client = $this->client;
        $endpoint = $this->baseUrl . '/countries';

        $request = $client->get(
            $endpoint,
            [
                'X-Mashape-Key' => $this->apiKey
            ],
            [
                'query' => [
                    'limit' => 1000
                ]
            ]
        );

        $response = $this->sendRequest($request);
        $responseData = json_decode($response->getBody(true), true);

        var_dump($responseData);
    }
}
