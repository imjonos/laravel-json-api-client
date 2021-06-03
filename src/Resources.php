<?php
namespace Nos\JsonApiClient;
use GuzzleHttp\Exception\GuzzleException;
use Nos\JsonApiClient\Interfaces\Resources as ResourcesInterface;
use IteratorAggregate;
use ArrayIterator;

class Resources implements ResourcesInterface, IteratorAggregate
{
    /**
     * @var Client
     */
    protected Client $client;

    /**
     * @var string
     */
    protected string $resourceUrl = '';

    /**
     * @var array
     */
    protected array $resources = [];

    /**
     * Resources constructor.
     * @param Client $client
     * @param string $resourceUrl
     */
    public function __construct(Client $client, string $resourceUrl = '')
    {
        $this->resourceUrl = $resourceUrl;
        $this->client = $client;
    }

    /**
     * Get resources
     *
     * @return array
     * @throws GuzzleException
     */
    public function get(): array
    {
        $resources = $this->getClient()->get($this->getUrl());
        $this->resources = [];

        foreach ($resources AS $resource){
            $this->resources[] = new Resource($this->getClient(), $this->getUrl(), $resource);
        }
        return $this->resources;
    }

    /**
     * Get included
     *
     * @param string $type
     * @param array $ids
     * @return array
     */
    public function getIncluded(string $type, array $ids = []): array
    {
        $result = [];
        foreach ($this->resources['included'] as $include) {
            if (in_array((int)$include['id'], $ids) && $include['type'] === $type) {
                $result[] = $include;
            }
        }
        return $result;
    }

    /**
     * Return array of resources
     *
     * @return array
     */
    public function toArray():array
    {
        return $this->resources;
    }

    /**
     * Iterator
     *
     * @return ArrayIterator
     */
    public function getIterator():ArrayIterator
    {
        return new ArrayIterator($this->toArray());
    }

    /**
     * Get client
     *
     * @return Client
     */
    public function getClient():Client
    {
        return $this->client;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->resourceUrl;
    }
}
