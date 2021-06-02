<?php
namespace Nos\JsonApiClient\Interfaces;
use Nos\JsonApiClient\Client;

Interface Resource
{
    /**
     * Get Resource
     *
     * @return array
     */
    public function get():array;

    /**
     * PATCH Resource
     *
     * @return array
     */
    public function patch():array;

    /**
     * POST Resource
     *
     * @return array
     */
    public function post():array;

    /**
     * DELETE Resource
     *
     * @return array
     */
    public function delete():array;

    /**
     * @return mixed
     */
    public function getClient():Client;

    /**
     * @return string
     */
    public function getUrl():string;
}