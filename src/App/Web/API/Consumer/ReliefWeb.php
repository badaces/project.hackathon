<?php

namespace App\Web\API\Consumer;

use App\Web\API\Entity\Country;
use CBC\Utility\Configuration;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Selectable;
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

    /**
     * @return Collection|Selectable|Country[]
     * @throws \App\Web\API\Exception\FailedRequestException
     */
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
        $countriesData = json_decode($response->getBody(true), true)['data'];

        $countries = new ArrayCollection();

        foreach ($countriesData as $countryData) {
            // @TODO: Create a CountryMapper that handles the creation of the entity.
            $countries->add(new Country(
                $countryData['id'],
                $countryData['score'],
                $countryData['href'],
                $countryData['fields']['name']
            ));
        }

        return $countries;
    }
}
