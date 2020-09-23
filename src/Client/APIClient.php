<?php

namespace App\Client;

use GuzzleHttp\Client;

class APIClient
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @var string
     */
    private $baseUri;

    public function __construct(string $baseUri)
    {
        $this->client = new Client([
            'base_uri' => $baseUri
        ]);
    }

    public function list(string $index): ?array
    {
        $response = $this->client->request('GET', 'os-api/' . $index);

        return \json_decode($response->getBody()->getContents());
    }
}
