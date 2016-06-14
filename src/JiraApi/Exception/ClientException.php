<?php

namespace madmis\JiraApi\Exception;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class ClientException
 * @package madmis\JiraApi\Exception
 */
class ClientException extends \RuntimeException implements JiraApiExceptionInterface
{
    /** @var RequestInterface */
    private $request;

    /** @var ResponseInterface */
    private $response;

    public function __construct(\Exception $ex, RequestInterface $request, ResponseInterface $response = null)
    {
        parent::__construct($ex->getMessage(), $ex->getCode(), $ex);
        $this->request = $request;
        $this->response = $response;
    }

    /**
     * Get the request that caused the exception
     *
     * @return RequestInterface
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * Get the associated response
     *
     * @return ResponseInterface|null
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * Check if a response was received
     *
     * @return bool
     */
    public function hasResponse()
    {
        return $this->response !== null;
    }
}
