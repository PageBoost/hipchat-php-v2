<?php
namespace PageBoost\HipChatV2\HttpClients;

use Resty\Resty;
use PageBoost\HipChatV2\HipChat;
use PageBoost\HipChatV2\Contracts\RequestInterface;
use PageBoost\HipChatV2\Response;

class RestyClient implements RequestInterface
{
    protected $client = null;

    protected $access_token = '';

    /**
     * @var null
     */
    protected $basicAuthUsername = null;

    /**
     * @var null
     */
    protected $basicAuthPassword = null;

    public function __construct($baseUrl, $client = null)
    {
        if (!is_null($client)) {
            $this->client = $client;
            return;
        }

        $client = new Resty();
        $client->setBaseURL($baseUrl.'/'.HipChat::API_VERSION.'/');
        $this->client = $client;
    }

    /**
     * @param string $access_token
     * @return void
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
        $request = $this->prepareRequest('GET', $uri, $queryParams);

        return $this->processRequest($request);
    }

    /**
     * @param       $uri
     * @param array $queryParams
     * @return \Guzzle\Http\Message\ResponseInterface
     */
    public function post($uri, $queryParams = array())
    {
        $request = $this->prepareRequest('POST', $uri, $queryParams);

        return $this->processRequest($request);
    }

    /**
     * @param       $uri
     * @param array $queryParams
     * @return \Guzzle\Http\Message\ResponseInterface
     */
    public function put($uri, $queryParams = array())
    {
        $request = $this->prepareRequest('PUT', $uri, $queryParams);

        return $this->processRequest($request);
    }

    /**
     * @param       $uri
     * @param array $queryParams
     * @return \Guzzle\Http\Message\ResponseInterface
     */
    public function delete($uri, $queryParams = array())
    {
        $request = $this->prepareRequest('DELETE', $uri, $queryParams);

        return $this->processRequest($request);
    }


    public function returnResponseObject($response)
    {
        $return = new Response();

        $response_array = $this->objectToArray($response['body']);

        $return->setRateLimit($response['headers']['X-Ratelimit-Limit']);
        $return->setRateRemaining($response['headers']['X-Ratelimit-Remaining']);
        $return->setRateReset($response['headers']['X-Ratelimit-Reset']);
        $return->setData($response_array);
        $return->setResponseCode($response['status']);

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

    private function prepareRequest($method, $uri, $queryParams)
    {
        $headers = array();
        if ($this->basicAuthUsername !== null and $this->basicAuthPassword != null) {
            $this->client->setCredentials($this->basicAuthUsername, $this->basicAuthPassword);
        } elseif (!empty($this->access_token)) {
            $headers['Authorization'] = 'Bearer '.$this->access_token;
        }
        switch($method) {
            case 'GET':
                $request = $this->client->get($uri, $queryParams, $headers);
                break;
            case 'POST':
                $headers['Content-Type'] = 'application/json';
                $queryParams = json_encode($queryParams);
                $request = $this->client->post($uri, $queryParams, $headers);
                break;
            case 'PUT':
                $headers['Content-Type'] = 'application/json';
                $queryParams = json_encode($queryParams);
                $request = $this->client->put($uri, $queryParams, $headers);
                break;
            case 'DELETE':
                $headers['Content-Type'] = 'application/json';
                $request = $this->client->delete($uri, $queryParams, $headers);
                break;
        }

        return $request;
    }

    private function processRequest($request)
    {
        if ($request['status'] == 200 or $request['status'] == 201 or $request['status'] == 204) {
            return $request;
        }
        $response_array = $this->objectToArray($request['body']);
        HipChat::throwException($response_array['error']['code'], $response_array['error']['message'], $request['meta']['uri']);
    }

    private function objectToArray($d)
    {
        if (is_object($d)) {
            $d = get_object_vars($d);
        }

        if (is_array($d)) {
            return array_map(array($this, __FUNCTION__), $d);
        } else {
            return $d;
        }
    }
}
