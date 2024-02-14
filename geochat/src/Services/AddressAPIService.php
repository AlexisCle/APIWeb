<?php
// src/Service/AddressAPIService.php
namespace App\Services;

use GuzzleHttp\Client;

class AddressAPIService
{
    public const BASE_URI = 'https://api-adresse.data.gouv.fr/';

    public function getLngLat(string $address): ?array
    {
        if(strlen($address)<3){
            return null;
        }
        $searchQ = self::BASE_URI . 'search/?q='.$address;
        $client = new Client();
        $response = $client->request('GET', $searchQ);
        echo $response->getStatusCode(); // 200
        echo $response->getHeaderLine('content-type'); // 'application/json; charset=utf8'
        echo $response->getBody();
        //send asyncronous request
        $promise = $client->requestAsync('GET', $searchQ)->then(function ($response) {
            echo $response->getBody();
        });
        $promise->wait();
        if($response->getBody() != null){
            return json_decode($response->getBody(), true);
        }
        return null;
    }
}
