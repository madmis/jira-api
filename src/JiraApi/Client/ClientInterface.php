<?php

namespace madmis\JiraApi\Client;

use madmis\JiraApi\Exception\JiraApiExceptionInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Interface ClientInterface
 */
interface ClientInterface
{
    /**
     * Send an HTTP request.
     *
     * @param RequestInterface $request Request to send
     * @param array $options Request options to apply to the given
     *                                  request and to the transfer.
     *
     * @return ResponseInterface
     * @throws JiraApiExceptionInterface
     */
    public function send(RequestInterface $request, array $options = []);
}