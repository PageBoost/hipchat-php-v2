<?php
namespace PageBoost\HipChatV2\Resources;

use PageBoost\HipChatV2\Contracts\RequestInterface;

class Sessions extends BaseExpand
{
    protected $request = null;

    protected $id = null;

    public function __construct($session_id, RequestInterface $request)
    {
        $this->id = $session_id;
        $this->request = $request;
    }

    public function get()
    {
        $queryParams = array();
        $session_id = $this->getId();

        $response = $this->request->get('oauth/token/'.$session_id, array_merge($queryParams, $this->expandQuery()));

        return $this->request->returnResponseObject($response);
    }

    public function create($grant_type, $_options = array())
    {
        $queryParams = array(
            'grant_type' => $grant_type,
        );
        if (isset($_options['username'])) {
            $queryParams['username'] = $_options['username'];
        }
        if (isset($_options['code'])) {
            $queryParams['code'] = $_options['code'];
        }
        if (isset($_options['redirect_uri'])) {
            $queryParams['redirect_uri'] = $_options['redirect_uri'];
        }
        if (isset($_options['scope'])) {
            $queryParams['scope'] = $_options['scope'];
        }
        if (isset($_options['password'])) {
            $queryParams['password'] = $_options['password'];
        }
        if (isset($_options['refresh_token'])) {
            $queryParams['refresh_token'] = $_options['refresh_token'];
        }

        $response = $this->request->post('oauth/token', $queryParams);

        $responseObject = $this->request->returnResponseObject($response);
        return $responseObject;
    }

    public function createOAuth($username, $password, $grant_type, $_options = array())
    {
        $this->request->setBasicAuth($username, $password);
        $result =  $this->create($grant_type, $_options);
        $this->request->setBasicAuth(null, null);

        return $result;
    }

    public function delete()
    {
        $queryParams = array();
        $session_id = $this->getId();

        $response = $this->request->delete('oauth/token/'.$session_id, $queryParams);

        return $this->request->returnResponseObject($response);
    }

    /**
     * @return null
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param null $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
}
