<?php

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class DataFetcher
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }
    public function fetchData(): array
    {
//        Get the data from the provided API

        $response=$this->client->request(
            'GET',
            'https://opendata.bordeaux-metropole.fr/api/records/1.0/search/?dataset=previsions_pont_chaban&q=&rows=75&facet=bateau'
        );

//        Get the data in an array instead of the json

        $content = $response->toArray();

//        Select and return specifics data about bridge closures

        $records=$content['records'];

        return $records;
    }
}