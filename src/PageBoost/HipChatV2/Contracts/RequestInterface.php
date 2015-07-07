<?php
namespace PageBoost\HipChatV2\Contracts;

use PageBoost\HipChatV2\Response;

/**
 * Interface RequestInterface
 *
 * @package PageBoost\HipChatV2\Contracts
 */
interface RequestInterface
{
    /**
     * @param $access_token
     * @return mixed
     */
    public function setAccessToken($access_token);

    /**
     * @return mixed
     */
    public function getAccessToken();

    /**
     * @param       $uri
     * @param array $queryParams
     * @return mixed
     */
    public function get($uri, $queryParams = array());

    /**
     * @param       $uri
     * @param array $queryParams
     * @return mixed
     */
    public function post($uri, $queryParams = array());

    /**
     * @param       $uri
     * @param array $queryParams
     * @return mixed
     */
    public function put($uri, $queryParams = array());

    /**
     * @param       $uri
     * @param array $queryParams
     * @return mixed
     */
    public function delete($uri, $queryParams = array());

    /**
     * @param $response
     * @return mixed
     */
    public function returnResponseObject($response);

    /**
     * @param $username
     * @param $password
     * @return void
     */
    public function setBasicAuth($username, $password);
}
