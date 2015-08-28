<?php


namespace madmis\JiraApi\Client;

use Buzz\Client\Curl;
use Buzz\Message\Request as BuzzRequest;
use Buzz\Message\Response as BuzzResponse;
use GuzzleHttp\Psr7\Response;
use madmis\JiraApi\Authentication\AuthenticationInterface;
use madmis\JiraApi\Exception\ClientException;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

/**
 * Class BuzzCurlClient
 * @package madmis\JiraApi\Client
 */
class BuzzCurlClient extends Curl implements ClientInterface
{
    /**
     * @var string
     */
    private $apiUri;

    /**
     * @var AuthenticationInterface
     */
    private $authentication;

    /**
     * @param AuthenticationInterface $authentication
     * @param string $apiUri
     */
    public function __construct(AuthenticationInterface $authentication, $apiUri)
    {
        parent::__construct();
        $this->authentication = $authentication;
        $this->apiUri = $apiUri;
    }


    /**
     * @param RequestInterface $request
     * @param array $options
     * @return ResponseInterface
     * @throws ClientException
     */
    public function send(RequestInterface $request, array $options = [])
    {
        $buzzRequest = new BuzzRequest(
            $request->getMethod(),
            $request->getUri()->getPath(),
            $request->getUri()->getHost()
        );
        $guzzleResponse = new BuzzResponse();

        try {
            parent::send($buzzRequest, $guzzleResponse, $options);
        } catch (\Buzz\Exception\ExceptionInterface $ex) {
            throw new ClientException($ex, $request, $guzzleResponse);
        }

        $response = new Response(
            $guzzleResponse->getStatusCode(),
            $guzzleResponse->getHeaders(),
            $guzzleResponse->getContent(),
            $guzzleResponse->getProtocolVersion()
        );

        return $response;
    }

    /**
     * Get jira api uri
     * @return string
     */
    public function getApiUri()
    {
        return $this->apiUri;
    }

    /**
     * @return AuthenticationInterface
     */
    public function getAuthentication()
    {
        return $this->authentication;
    }
}