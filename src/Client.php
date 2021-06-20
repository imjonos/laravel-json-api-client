<?php


namespace Nos\JsonApiClient;


use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Exception\GuzzleException;
use Nos\JsonApiClient\Interfaces\Client as ClientInterface;
use Psr\Http\Message\ResponseInterface;

class Client implements ClientInterface
{
    /**
     * @var GuzzleHttpClient|null
     */
    protected ?GuzzleHttpClient $httpClient = null;

    /**
     * @var array|null
     */
    protected ?array $token = null;

    /**
     * @var string
     */
    protected string $apiUrl = '';

    /**
     * @var string
     */
    protected string $clientId = '';

    /**
     * @var string
     */
    protected string $clientSecret = '';

    /**
     * @var int
     */
    protected int $pageSize = 700;

    /**
     * Client constructor.
     * @throws GuzzleException
     */
    public function __construct(string $apiUrl = '', string $clientId = '', string $clientSecret = '')
    {
        $this->apiUrl = $apiUrl ?? config('jsonapiclient.url');
        $this->clientId = $clientId ?? config('jsonapiclient.client_id');
        $this->clientSecret = $clientSecret ?? config('jsonapiclient.client_secret');
    }

    /**
     * Get Access Token
     * @return array
     * @throws GuzzleException
     */
    public function getToken(): ?array
    {
        if (!$this->token) {
            $response =  $this->getHttpClient()->request('POST', $this->apiUrl . '/oauth/token', [
                'form_params' => [
                    'grant_type' => 'client_credentials',
                    'client_id' => $this->clientId,
                    'client_secret' => $this->clientSecret,
                    'scope' => '*'
                ]]);
            $this->token = json_decode((string)$response->getBody(), true);
        }
        return $this->token;
    }

    /**
     * GET Resource
     *
     * @param string $uri
     * @param array $query
     * @return array
     * @throws GuzzleException
     */
    public function get(string $uri, array $query = []): array
    {
        $response = $this->sendApiRequest('GET', $this->apiUrl . $uri, ['query' => $query]);
        return json_decode((string)$response->getBody(), true);
    }

    /**
     * PATCH Resource
     *
     * @param string $uri
     * @param array $data
     * @return array
     * @throws GuzzleException
     */
    public function patch(string $uri, array $data = []): array
    {
        $response = $this->sendApiRequest('PATCH', $this->apiUrl . $uri, ['form_params' => $data]);
        return json_decode((string)$response->getBody(), true);
    }

    /**
     * POST Resource
     *
     * @param string $uri
     * @param array $data
     * @return ?array
     * @throws GuzzleException
     */
    public function post(string $uri, array $data = []): ?array
    {
        $response = $this->sendApiRequest('POST', $this->apiUrl . $uri, ['form_params' => $data]);
        return json_decode((string)$response->getBody(), true);
    }

    /**
     * DELETE Resource
     *
     * @param string $uri
     * @return array
     * @throws GuzzleException
     */
    public function delete(string $uri): array
    {
        $response = $this->sendApiRequest('DELETE', $this->apiUrl . $uri);
        return json_decode((string)$response->getBody(), true);
    }

    /**
     * Send API request
     *
     * @param string $method
     * @param string $url
     * @param array $params
     * @return ResponseInterface
     * @throws GuzzleException
     * @throws \Exception
     */
    protected function sendApiRequest(string $method = 'GET', string $url = '', array $params = []): ResponseInterface
    {
        $token = $this->getToken();

        if (!$token) {
            throw new \Exception('Token is empty!');
        }

        $requestParams = array_merge($params, [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer ' . $token['access_token']
            ]
        ]);
        return $this->getHttpClient()->request($method, $url, $requestParams);
    }

    /**
     * Get HTTP Client
     *
     * @return GuzzleHttpClient
     */
    protected function getHttpClient(): ?GuzzleHttpClient
    {
        if (!$this->httpClient) {
            $this->httpClient = new GuzzleHttpClient();
        }
        return $this->httpClient;
    }

}
