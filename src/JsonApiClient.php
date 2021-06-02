<?php

namespace Nos\JsonApiClient;

use Illuminate\Support\Facades\App;

class JsonApiClient
{
    /**
     * @param string $url
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function resources(string $url = ''):array
    {
        $resources = new Resources(App::make(Client::class), $url);
        return $resources->get();
    }

    /**
     * @param string $url
     * @param array $data
     * @return Resource
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function create(string $url, array $data = []): Resource
    {
        $resource = new Resource(App::make(Client::class), $url, $data);
        $resource->post();
        return $resource;
    }

    /**
     * @param string $url
     * @param array $data
     * @return Resource
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update(string $url, array $data = []): Resource
    {
        $resource = new Resource(App::make(Client::class), $url, $data);
        $resource->patch();
        return $resource;
    }

    /**
     * @param string $url
     * @param array $data
     * @return Resource
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete(string $url, array $data = []): Resource
    {
        $resource = new Resource(App::make(Client::class), $url, $data);
        $resource->delete();
        return $resource;
    }
}