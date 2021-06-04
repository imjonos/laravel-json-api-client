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
    protected array $data = [];

    /**
     * @var array
     */
    protected array $meta = [];

    /**
     * @var array
     */
    protected array $included = [];


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
     * @param array $query
     * @return array
     * @throws GuzzleException
     */
    public function get(array $query = []): array
    {
        $this->data = [];
        $resources = $this->getClient()->get($this->getUrl(), $query);
        if(isset($resources['meta'])) $this->meta = $resources['meta'];
        if(isset($resources['included'])) $this->included = $resources['included'];

        foreach ($resources['data'] AS $resource){
            $this->data[] = new Resource($this->getClient(), $this->getUrl(), ['data' => $resource]);
        }
        return $this->data;
    }

    /**
     * Chunking Results From Api
     *
     * @param int $size
     * @param callable $callback
     */
    public function chunk(int $size = 700, callable $callback):void
    {
        $pageNumber = 1;
        $lastPage = 1;
        $total = 0;
        do {
            $this->get([
                'page' => [
                    'size' => $size,
                    'number' => $pageNumber
                ]
            ]);

            if ($total === 0) {
                $lastPage = (int)$this->meta['last_page'];
                $total = (int)$this->meta['total'];
            }

            $callback($this->data, $pageNumber, $total);

            $pageNumber++;
        } while ($pageNumber < $lastPage);
    }

     /**
     * Get included
     *
     * @param string $type
     * @param array $ids
     * @return array
     */
    public function getIncluded(string $type = '', array $ids = []): array
    {
        $result = [];

        if(!count($ids) && !$type){
            $result = $this->included;
        }else {
            foreach ($this->included as $include) {
                if (count($ids) && $type) {
                    if (in_array((int)$include['id'], $ids) && $include['type'] === $type) {
                        $result[] = $include;
                    }
                } else if (!count($ids) && $type) {
                    if ($include['type'] === $type) {
                        $result[] = $include;
                    }
                }
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
        return $this->data;
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
     * Get Meta
     *
     * @return array
     */
    public function getMeta(): array
    {
        return $this->meta;
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
