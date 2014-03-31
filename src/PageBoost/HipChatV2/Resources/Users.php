<?php
namespace PageBoost\HipChatV2\Resources;

use PageBoost\HipChatV2\Contracts\RequestInterface;
use PageBoost\HipChatV2\HipChat;

class Users extends BaseExpand
{
    protected $request = null;

    protected $id = null;

    public function __construct($user_id, RequestInterface $request)
    {
        $this->id = $user_id;
        $this->request = $request;
    }

    public function all($include_guests = false, $include_deleted = false, $startIndex = 0, $maxResult = 100)
    {
        $queryParams = [
            'include-guests' => $include_guests,
            'include-deleted' => $include_deleted,
            'start-index' => $startIndex,
            'max-results' => $maxResult,
        ];

        $response = $this->request->get('user', array_merge($queryParams, $this->expandQuery()));

        return $this->request->returnResponseObject($response);
    }

    public function get()
    {
        $queryParams = [];
        $user_id = $this->getId();

        $response = $this->request->get('user/'.$user_id, array_merge($queryParams, $this->expandQuery()));

        return $this->request->returnResponseObject($response);
    }

    public function create($name, $email, $_options = array())
    {
        $queryParams = [
            'name' => $name,
            'email' => $email,
        ];
        if (isset($_options['title'])) {
            $queryParams['title'] = $_options['title'];
        }
        if (isset($_options['title'])) {
            $queryParams['title'] = $_options['title'];
        }
        if (isset($_options['mention_name'])) {
            $queryParams['mention_name'] = $_options['mention_name'];
        }
        if (isset($_options['is_group_admin'])) {
            $queryParams['is_group_admin'] = $_options['is_group_admin'];
        }
        if (isset($_options['timezone'])) {
            $queryParams['timezone'] = $_options['timezone'];
        }
        if (isset($_options['password'])) {
            $queryParams['password'] = $_options['password'];
        }

        $response = $this->request->post('user', $queryParams);

        $responseObject = $this->request->returnResponseObject($response);
        if ($responseObject->getResponseCode() == 201) {
            $getData = $responseObject->getData();
            $this->setId($getData['id']);
        }
        return $responseObject;
    }

    public function send($message)
    {
        $queryParams = [
            'message' => $message,
        ];
        $user_id = $this->getId();

        $response = $this->request->post('user/'.$user_id.'/message', $queryParams);

        return $this->request->returnResponseObject($response);
    }

    /**
     * Update user
     * All values are required except password one which is optional!
     *
     * @param string $name
     * @param string $email
     * @param string $mention_name
     * @param string $timezone
     * @param bool   $is_group_admin
     * @param string $title
     * @param null   $password
     * @return
     */
    public function update($name, $email, $mention_name, $timezone = 'UTC', $is_group_admin = false, $title = '', $password = null)
    {
        $queryParams = [
            'name' => $name,
            'title' => $title,
            'mention_name' => $mention_name,
            'is_group_admin' => $is_group_admin,
            'timezone' => $timezone,
            'email' => $email,
        ];
        if ($password != null) {
            $queryParams['password'] = $password;
        }
        $user_id = $this->getId();

        $response = $this->request->put('user/'.$user_id.'', $queryParams);

        return $this->request->returnResponseObject($response);
    }

    public function delete()
    {
        $queryParams = [];
        $user_id = $this->getId();

        $response = $this->request->delete('user/'.$user_id, array_merge($queryParams, $this->expandQuery()));

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
