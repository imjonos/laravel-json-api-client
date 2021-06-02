<?php

namespace Nos\JsonApiClient\Interfaces;

Interface Client
{
    /**
     * Get Access Token
     * @return array
     */
    public function getToken(): ?array;


    /**
     * Get Resource
     *
     * @param string $uri
     * @return array
     */
    public function get(string $uri):array;

    /**
     * PATCH Resource
     *
     * @param string $uri
     * @param array $data
     * @return array
     */
    public function patch(string $uri, array $data = []):array;

    /**
     * POST Resource
     *
     * @param string $uri
     * @param array $data
     * @return array
     */
    public function post(string $uri, array $data = []):array;

    /**
     * DELETE Resource
     *
     * @param string $uri
     * @return array
     */
    public function delete(string $uri):array;
}