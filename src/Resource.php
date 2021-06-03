<?php


namespace Nos\JsonApiClient;
use Nos\JsonApiClient\Interfaces\Resource as ResourceInterface;

class Resource implements ResourceInterface
{

    /**
     * @var array
     */
    protected array $resource = [];

    /**
     * @var Client
     */
    protected Client $client;

    /**
     * @var string
     */
    protected string $resourceUrl = '';

    /**
     * Resource constructor.
     * @param Client $client
     * @param string $resourceUrl
     * @param array $resource
     */
    public function __construct(Client $client, string $resourceUrl, array $resource = [])
    {
        $this->resource = $resource['data'];
        $this->resourceUrl = $resourceUrl;
        $this->client = $client;
    }

    /**
     * @param string $property
     * @param $value
     * @return mixed
     */
    public function __set(string $property, $value)
    {
        return $this->resource[$property] = $value;
    }


    /**
     * @param string $property
     * @return mixed|null
     */
    public function __get(string $property)
    {
        return array_key_exists($property, $this->resource)
            ? $this->resource[$property]
            : null;
    }

    /**
     * Get ids from Many Relationship
     *
     * @param string $type
     * @return array
     */
    public function getRelationshipIds(string $type = ''): array
    {
        $ids = [];
        if(isset($this->resource['relationships']) && isset($this->resource['relationships'][$type])) {
            foreach ($this->resource['relationships'][$type]['data'] as $value) {
                $ids[] = (int)$value['id'];
            }
        }
        return $ids;
    }

    /**
     * Get resource
     *
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get(array $query = []): array
    {
        return $this->getClient()->get($this->getUrl(), $query);
    }

    /**
     * Patch resource
     *
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function patch(): array
    {
        return $this->getClient()->patch($this->getUrl(), ['data' => $this->resource]);
    }

    /**
     * Post resource
     *
     * @return array
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function post(): array
    {
        return $this->getClient()->post($this->getUrl(), ['data' => $this->resource]);
    }

    /**
     * Delete resource
     *
     * @return array
     */
    public function delete(): array
    {
        return $this->$this->getClient()->delete($this->getUrl());
    }

    /**
     * Get client
     *
     * @return mixed|void
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
        return $this->resourceUrl.'/'.$this->resource['id'];
    }
}
