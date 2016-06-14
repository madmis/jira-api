<?php

namespace madmis\JiraApi\Endpoint;

use madmis\JiraApi\Client\ClientInterface;

/**
 * Class EndpointFactory
 * @package madmis\JiraApi\Endpoint
 */
class EndpointFactory
{
    /**
     * @var array
     */
    protected $endpointList = [];

    /**
     * @param string $type endpoint type or class
     * @param ClientInterface $client
     * @return EndpointInterface
     * @throws \InvalidArgumentException
     */
    public function getEndpoint($type, ClientInterface $client)
    {
        if (!array_key_exists($type, $this->endpointList)) {
            if (class_exists($type)) {
                $this->endpointList[$type] = new $type($client);
            } else {
                $className = sprintf('%s\%sEndpoint', __NAMESPACE__, ucfirst($type));
                if (!class_exists($className)) {
                    throw new \InvalidArgumentException("{$className} is not valid endpoint");
                }

                $this->endpointList[$type] = new $className($client);
            }
        }

        return $this->endpointList[$type];
    }
}
