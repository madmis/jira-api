<?php

namespace madmis\JiraApi\Endpoint;

use madmis\JiraApi\Client\ClientInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class AbstractEndpoint
 * @package madmis\JiraApi\Endpoint
 */
abstract class AbstractEndpoint implements EndpointInterface
{
    /**
     * @var ClientInterface
     */
    protected $client;

    /**
     * @var string
     */
    protected $baseUrn = '/';

    /**
     * @param ClientInterface $client
     */
    public function __construct(ClientInterface $client)
    {
        $this->client = $client;
    }

    /**
     * @param array $params
     * @return string
     */
    public function getApiUri(array $params = [])
    {
        $path = $params ? implode('/', $params) : '';

        return sprintf('%s%s/%s', $this->client->getApiUri(), $this->baseUrn, $path);
    }

    /**
     * @param ResponseInterface $response
     * @return array
     */
    protected function processResponse(ResponseInterface $response)
    {
        return json_decode($response->getBody()->getContents(), true);
    }
}
