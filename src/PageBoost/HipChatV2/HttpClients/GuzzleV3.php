<?php
namespace PageBoost\HipChatV2\HttpClients;

use Guzzle\Http\Client;
use Guzzle\Http\Message\Request;
use Guzzle\Http\Message\ResponseInterface as GuzzleResponse;
use Guzzle\Http\Message\RequestInterface as GuzzleRequest;
use Guzzle\Http\Exception\TransferException;
use PageBoost\HipChatV2\HipChat;
use PageBoost\HipChatV2\Contracts\RequestInterface;
use PageBoost\HipChatV2\Response;

class GuzzleV3 implements RequestInterface
{
    /**
     * @var \Guzzle\Http\Client|null
     */
    protected $client = null;

    /**
     * @var string
     */
    protected $access_token = '';

    /**
     * @var null
     */
    protected $basicAuthUsername = null;

    /**
     * @var null
     */
    protected $basicAuthPassword = null;

    /**
     * @param null $client
     */
    public function __construct($client = null)
    {
        if (!is_null($client)) {
            $this->client = $client;
            return;
        }

        $client = new Client(HipChat::BASE_URL.'/{version}/', array(
            'version'=>HipChat::API_VERSION
        ));

        $this->client = $client;
    }

    /**
     * @param string $access_token
     * @return mixed|void
     */
    public function setAccessToken($access_token)
    {
        $this->access_token = $access_token;
    }

    /**
     * @return string
     */
    public function getAccessToken()
    {
        return $this->access_token;
    }

    /**
     * @param       $uri
     * @param array $queryParams
     * @return \Guzzle\Http\Message\ResponseInterface
     */
    public function get($uri, $queryParams = array())
    {
        $request = $this->prepareRequest('GET', $uri);

        if (count($queryParams) > 0) {
            $query = $request->getQuery();
            $query->merge($queryParams);
        }

        return $this->processRequest($request);
    }

    /**
     * @param       $uri
     * @param array $queryParams
     * @return \Guzzle\Http\Message\ResponseInterface
     */
    public function post($uri, $queryParams = array())
    {
        $request = $this->prepareRequest('POST', $uri);

        if (count($queryParams) > 0) {
            $json_body = json_encode($queryParams);
            $request->setBody($json_body, 'application/json');
        }

        return $this->processRequest($request);
    }

    /**
     * @param       $uri
     * @param array $queryParams
     * @return \Guzzle\Http\Message\ResponseInterface
     */
    public function put($uri, $queryParams = array())
    {
        $request = $this->prepareRequest('put', $uri);

        if (count($queryParams) > 0) {
            $json_body = json_encode($queryParams);
            $request->setBody($json_body, 'application/json');
        }

        return $this->processRequest($request);
    }

    /**
     * @param       $uri
     * @param array $queryParams
     * @return \Guzzle\Http\Message\ResponseInterface
     */
    public function delete($uri, $queryParams = array())
    {
        $request = $this->prepareRequest('delete', $uri);

        return $this->processRequest($request);
    }

    /**
     * @param \Guzzle\Http\Message\ResponseInterface $response
     * @return Response
     */
    public function returnResponseObject($response)
    {
        $return = new Response();

        $rateLimitArray = $response->getHeader('X-RateLimit-Limit')->toArray();
        $rateRemainingArray = $response->getHeader('X-RateLimit-Remaining')->toArray();
        $rateResetArray = $response->getHeader('X-RateLimit-Reset')->toArray();

        $return->setRateLimit($rateLimitArray[0]);
        $return->setRateRemaining($rateRemainingArray[0]);
        $return->setRateReset($rateResetArray[0]);
        $return->setData($response->json());
        $return->setResponseCode($response->getStatusCode());

        return $return;
    }

    /**
     * @param $username
     * @param $password
     */
    public function setBasicAuth($username, $password)
    {
        $this->basicAuthUsername = $username;
        $this->basicAuthPassword = $password;
    }

    /**
     * @param $method
     * @param $uri
     * @return \Guzzle\Http\Message\RequestInterface
     */
    private function prepareRequest($method, $uri)
    {
        $request = $this->client->createRequest($method, $uri);

        if ($this->basicAuthUsername !== null and $this->basicAuthPassword != null) {
            $request->setAuth($this->basicAuthUsername, $this->basicAuthPassword);
        } elseif (!empty($this->access_token)) {
            $request->addHeader('Authorization', 'Bearer '.$this->access_token);
        }

        return $request;
    }

    /**
     * @param GuzzleRequest $request
     * @return GuzzleRequest
     */
    private function processRequest(GuzzleRequest $request)
    {
        try {
            $response = $this->client->send($request);
        } catch (TransferException $e) {
            $json_exception = $e->getResponse()->json();
            HipChat::throwException($json_exception['error']['code'], $json_exception['error']['message']);
        }
        return $response;
    }
}
