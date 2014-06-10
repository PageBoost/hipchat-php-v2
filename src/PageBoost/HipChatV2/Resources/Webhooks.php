<?php
namespace PageBoost\HipChatV2\Resources;

use PageBoost\HipChatV2\Contracts\RequestInterface;
use PageBoost\HipChatV2\HipChat;

class Webhooks extends BaseExpand
{
    protected $request = null;

    protected $room_id = null;
    protected $hook_id = null;

    public function __construct($room_id, $hook_id, RequestInterface $request)
    {
        $this->room_id = $room_id;
        $this->hook_id = $hook_id;
        $this->request = $request;
    }

    public function all($startIndex = 0, $maxResult = 100)
    {
        $queryParams = array(
            'start-index' => $startIndex,
            'max-results' => $maxResult,
        );
        $room_id = $this->getRoomId();

        $response = $this->request->get('room/'.$room_id.'/webhook', array_merge($queryParams, $this->expandQuery()));

        return $this->request->returnResponseObject($response);
    }

    public function get()
    {
        $queryParams = array();
        $room_id_or_name = $this->getRoomId();
        $hook_id = $this->getHookId();

        $response = $this->request->get('room/'.$room_id_or_name.'/webhook/'.$hook_id, array_merge($queryParams, $this->expandQuery()));

        return $this->request->returnResponseObject($response);
    }

    public function create($url, $event, $pattern = '', $name = '')
    {
        $queryParams = array(
            'url' => $url,
            'event' => $event,
            'pattern' => $pattern,
            'name' => $name,
        );
        $room_id_or_name = $this->getRoomId();

        $response = $this->request->post('room/'.$room_id_or_name.'/webhook', $queryParams);

        $responseObject = $this->request->returnResponseObject($response);
        if ($responseObject->getResponseCode() == 201) {
            $getData = $responseObject->getData();
            $this->setHookId($getData['id']);
        }
        return $responseObject;
    }

    public function delete()
    {
        $queryParams = array();
        $room_id_or_name = $this->getRoomId();
        $hook_id = $this->getHookId();

        $response = $this->request->delete('room/'.$room_id_or_name.'/webhook/'.$hook_id, array_merge($queryParams, $this->expandQuery()));

        return $this->request->returnResponseObject($response);
    }

    /**
     * @return null
     */
    public function getRoomId()
    {
        return $this->room_id;
    }

    /**
     * @param null $room_id
     */
    public function setRoomId($room_id)
    {
        $this->room_id = $room_id;
        return $this;
    }

    /**
     * @return null
     */
    public function getHookId()
    {
        return $this->hook_id;
    }

    /**
     * @param null $hook_id
     */
    public function setHookId($hook_id)
    {
        $this->hook_id = $hook_id;
        return $this;
    }
}
