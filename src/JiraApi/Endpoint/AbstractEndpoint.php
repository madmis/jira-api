<?php

namespace madmis\JiraApi\Endpoint;

use JMS\Serializer\SerializerBuilder;
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

    /**
     * @param array $items
     * @param string $className
     * @return array|object[]
     */
    protected function deserializeItems(array $items, $className)
    {

        foreach($items as $key => $item) {
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
}
