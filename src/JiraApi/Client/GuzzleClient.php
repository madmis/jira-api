<?php

namespace madmis\JiraApi\Client;

use GuzzleHttp\Client;
use madmis\JiraApi\Exception\ClientException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

class GuzzleClient extends Client implements ClientInterface
{
    /**
     * @param RequestInterface $request
     * @param array $options
     * @return ResponseInterface
     */
    public function send(RequestInterface $request, array $options = [])
    {
        try {
            /** @var ResponseInterface $response */
            $response = parent::send($request, $options);
        } catch (\GuzzleHttp\Exception\GuzzleException $ex) {
            throw new ClientException($ex->getMessage(), $ex->getCode(), $ex);
        }

        return $response;
    }
}