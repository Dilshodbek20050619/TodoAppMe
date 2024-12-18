<?php

namespace App;

use Dotenv\Dotenv;
use GuzzleHttp\Client;

class Bot
{
    private $client;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => 'https://api.telegram.org/'.  $_ENV['TELEGRAM_TOKEN'] . "/"
        ]);
    }
    public function makeRequest (string $method, array $params) {
        $this->client->post($method, ['json' => $params]);
    }
}
