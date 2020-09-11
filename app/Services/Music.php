<?php

namespace App\Services;

use App\Helpers\StringHelper;

class Music
{
    /**
     * @var ElasticSearch
     */
    private $elasticSearch;

    /**
     * @param ElasticSearch $elasticSearch
     */
    public function setElasticSearch(ElasticSearch $elasticSearch)
    {
        $this->elasticSearch = $elasticSearch;
    }

    /**
     * @return ElasticSearch
     */
    public function getElasticSearch()
    {
        return $this->elasticSearch ?? $this->createDefaultElasticSearch();
    }

    /**
     * @return ElasticSearch
     */
    public function createDefaultElasticSearch()
    {
        return new ElasticSearch();
    }

    /**
     * @param array $params
     * @return mixed
     */
    public function index(array $params)
    {
        $data['music'] = StringHelper::removeAccents($params['text'] ?? '');
        $data = $this->getElasticSearch()->createSearchParams($data);

        $results = $this->getElasticSearch()->search($data);

        return $this->getElasticSearch()->getData($results);
    }

    /**
     * @param array $params
     */
    public function store(array $params)
    {
        $hashId = StringHelper::hashId($params);

        if (!$this->getElasticSearch()->exists($hashId)) {
            $this->getElasticSearch()->create($hashId, $params);
        }
    }
}
