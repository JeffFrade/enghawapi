<?php

namespace App\Services;

use Elasticsearch\Client;

class ElasticSearch
{
    /**
     * @var Client
     */
    private $client;

    /**
     * @param Client $client
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    /**
     * @return Client|\Illuminate\Contracts\Foundation\Application|mixed
     */
    public function getClient()
    {
        return $this->client ?? $this->createDefaultClient();
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     */
    public function createDefaultClient()
    {
        return app(Client::class);
    }

    /**
     * @param array $body
     * @return array
     */
    public function search(array $body = [])
    {
        $data = [
            'index' => env('ES_INDEX'),
            'body' => $body
        ];

        return $this->getClient()->search($data);
    }

    /**
     * @param string $hash
     * @param array $body
     * @param bool $refresh
     * @return array
     */
    public function create(string $hash, array $body, bool $refresh = true)
    {
        $data = [
            'index' => env('ES_INDEX'),
            'id' => $hash,
            'body' => $body,
            'refresh' => $refresh
        ];

        return $this->getClient()->create($data);
    }

    /**
     * @param string $idHash
     * @return bool
     */
    public function exists(string $idHash)
    {
        $data = [
            'index' => env('ES_INDEX'),
            'id' => $idHash
        ];

        if ($this->getClient()->exists($data)) {
            return true;
        }

        return false;
    }

    /**
     * @param array $search
     * @return array
     */
    public function createSearchParams(array $search)
    {
        return [
            'query' => [
                'match' => $search
            ]
        ];
    }

    /**
     * @param array $results
     * @return mixed
     */
    public function getData(array $results)
    {
        return $results['hits']['hits'];
    }
}
