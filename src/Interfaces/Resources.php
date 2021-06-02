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
     * @return mixed
     */
    public function getClient():Client;

    /**
     * @return string
     */
    public function getUrl():string;

    /**
     * Get included
     *
     * @param string $type
     * @param array $ids
     * @return array
     */
    public function getIncluded(string $type, array $ids = []): array;
}