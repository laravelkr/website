<?php

namespace App\Services\ModernPug;

use App\Services\ModernPug\Dto\Response;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use JsonMapper;

class Recruits
{
    public function __construct(protected Client $client, protected JsonMapper $jsonMapper, protected string $token)
    {
    }

    /**
     * @throws \JsonMapper_Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \JsonException
     */
    public function getAll()
    {
        $recruits = $this->client->get('https://modernpug.org/api/v1/recruits', [

            RequestOptions::HEADERS => [
                "Authorization" => "Bearer ".$this->token,
            ],
        ])
            ->getBody()
            ->getContents();

        $json = json_decode($recruits, false, 512, JSON_THROW_ON_ERROR);

        return $this->jsonMapper->map($json, new Response());
    }
}
