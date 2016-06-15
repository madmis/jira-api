<?php

namespace madmis\JiraApi\Endpoint;

use GuzzleHttp\Psr7\Request;
use JMS\Serializer\SerializerBuilder;
use madmis\JiraApi\Client\ClientInterface;
use madmis\JiraApi\Exception\ClientException;
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
     * @var bool
     */
    protected $mapping = false;

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
    public function getApiUrn(array $params = [])
    {
        $path = $params ? implode('/', $params) : '';

        return sprintf('%s%s/%s', $this->client->getApiUrn(), $this->baseUrn, $path);
    }

    /**
     * @param ResponseInterface $response
     * @return array
     */
    protected function processResponse(ResponseInterface $response)
    {
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @param array $items
     * @param string $className
     * @return array|object[]
     */
    protected function deserializeItems(array $items, $className)
    {

        foreach ($items as $key => $item) {
            $items[$key] = $this->deserializeItem($item, $className);
        }

        return $items;
    }

    /**
     * @param array $item
     * @param string $className
     * @return object
     */
    protected function deserializeItem(array $item, $className)
    {
        $serializer = SerializerBuilder::create()->build();
        return $serializer->deserialize(json_encode($item), $className, 'json');
    }

    /**
     * @param string $method Http::METHOD_
     * @param string $uri
     * @return Request
     */
    protected function createRequest($method, $uri)
    {
        $headers = [];
        if ($this->client->getAuthentication()) {
            $headers = $this->client->getAuthentication()->getHeaders();
        }

        return new Request($method, $uri, $headers);
    }

    /**
     * @param string $method Http::METHOD_
     * @param string $uri
     * @param array $options Request options to apply to the given
     *                                  request and to the transfer.
     * @return array response
     * @throws ClientException
     */
    public function sendRequest($method, $uri, array $options = [])
    {
        $request = $this->createRequest($method, $uri);

        return $this->processResponse(
            $this->client->send($request, $options)
        );
    }
}
