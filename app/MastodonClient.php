<?php

namespace App;

use GuzzleHttp\Client;

class MastodonClient {

    /**
     * @var Client
     */
    private $client;

    /**
     * @var array
     */
    private $params;

    public function __construct()
    {
        $this->client = new Client([
            'base_uri' => env('MASTODON_INSTANCE') . '/api/v1/',
        ]);

        $this->params = [
            'access_token' => env('MASTODON_API_KEY'),
        ];
    }

    public function toot(string $toot)
    {
        $this->client->post('statuses', [
            'query' => array_merge($this->params, [
                'status' => $toot,
            ])
        ]);
    }

}
