<?php

namespace App\Libraries\Parser;

use GuzzleHttp\Client;

class BaseParser {
    protected ?Client $client = null;

    protected function fetchUrl($url)
    {
        if (!$this->client) {
            $this->client = new \GuzzleHttp\Client;
        }

        $res = $this->client->get($url);
        if ($res->getStatusCode() !== 200) {
            throw new \Exception('Error reading URL: ' . $url);
        };

        return $res->getBody()->getContents();
    }
}
