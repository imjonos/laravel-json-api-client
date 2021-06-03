<?php
namespace Nos\JsonApiClient\Interfaces;
use Nos\JsonApiClient\Client;

Interface Resources
{
    /**
     * Get resources
     *
     * @return array
     */
    public function get():array;

    /**
     * Get HTTP client
     *
     * @return mixed
     */
    public function getClient():Client;

    /**
     * Get Url
     *
     * @return string
     */
    public function getUrl():string;

    /**
     * Return array of resources
     *
     * @return array
     */
    public function toArray():array;

    /**
     * Get included
     *
     * @param string $type
     * @param array $ids
     * @return array
     */
    public function getIncluded(string $type, array $ids = []): array;
}