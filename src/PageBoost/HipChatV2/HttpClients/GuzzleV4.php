<?php
namespace PageBoost\HipChatV2\HttpClients;

use GuzzleHttp\Client;
use GuzzleHttp\Message\Request;
use GuzzleHttp\Message\ResponseInterface as GuzzleResponse;
use GuzzleHttp\Message\RequestInterface as GuzzleRequest;
use GuzzleHttp\Stream\Stream;
use GuzzleHttp\Exception\TransferException;
use PageBoost\HipChatV2\HipChat;
use PageBoost\HipChatV2\Contracts\RequestInterface;
use PageBoost\HipChatV2\Response;

/**
 * Class GuzzleV4
 *
 * @package PageBoost\HipChatV2\HttpClients
 */
class GuzzleV4 implements RequestInterface
{
    /**
     * @var \GuzzleHttp\Client|null
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

        $client = new Client(array(
            'base_url' => array(HipChat::BASE_URL.'/{version}/', array('version' => HipChat::API_VERSION)),
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
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function get($uri, $queryParams = array())
    {
        $request = $this->prepareRequest('GET', $uri);

        if (count($queryParams) > 0) {
            $request = $request->setQuery($queryParams);
        }

        return $this->processRequest($request);
    }

    /**
     * @param       $uri
     * @param array $queryParams
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function post($uri, $queryParams = array())
    {
        $request = $this->prepareRequest('POST', $uri);

        if (count($queryParams) > 0) {
            $json_body = json_encode($queryParams);
            $request = $request->setHeader('content-type', 'application/json');
            $request = $request->setBody(Stream::factory($json_body));
        }

        return $this->processRequest($request);
    }

    /**
     * @param       $uri
     * @param array $queryParams
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function put($uri, $queryParams = array())
    {
        $request = $this->prepareRequest('put', $uri);

        if (count($queryParams) > 0) {
            $json_body = json_encode($queryParams);
            $request = $request->setHeader('content-type', 'application/json');
            $request = $request->setBody(Stream::factory($json_body));
        }

        return $this->processRequest($request);
    }

    /**
     * @param       $uri
     * @param array $queryParams
     * @return \GuzzleHttp\Message\ResponseInterface
     */
    public function delete($uri, $queryParams = array())
    {
        $request = $this->prepareRequest('delete', $uri);

//        if (count($queryParams) > 0) {
//            $json_body = json_encode($queryParams);
//            $request = $request->setHeader('content-type', 'application/json');
//            $request = $request->setBody(Stream::factory($json_body));
//        }

        return $this->processRequest($request);
    }

    /**
     * @param \GuzzleHttp\Message\ResponseInterface $response
     * @return Response
     */
    public function returnResponseObject($response)
    {
        $return = new Response();
        $return->setRateLimit($response->getHeader('X-RateLimit-Limit'));
        $return->setRateRemaining($response->getHeader('X-RateLimit-Remaining'));
        $return->setRateReset($response->getHeader('X-RateLimit-Reset'));
        $return->setData($response->json());
        $return->setResponseCode($response->getStatusCode());

        return $return;
    }

    /**
     * @param $username
     * @param $password
     * @return void
     */
    public function setBasicAuth($username, $password)
    {
        $this->basicAuthUsername = $username;
        $this->basicAuthPassword = $password;
    }

    /**
     * @param $method
     * @param $uri
     * @return \GuzzleHttp\Message\RequestInterface
     */
    private function prepareRequest($method, $uri)
    {
        $request = $this->client->createRequest($method, $uri);

        if ($this->basicAuthUsername !== null and $this->basicAuthPassword != null) {
            $request->setHeader(
                'Authorization',
                'Basic ' . base64_encode($this->basicAuthUsername.':'.$this->basicAuthPassword)
            );
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
