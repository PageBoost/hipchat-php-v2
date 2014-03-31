<?php
namespace PageBoost\HipChatV2\Resources;

use PageBoost\HipChatV2\Contracts\RequestInterface;
use PageBoost\HipChatV2\HipChat;

class Rooms extends BaseExpand
{
    protected $request = null;

    protected $id = null;

    public function __construct($room_id, RequestInterface $request, $webhookResources = null)
    {
        $this->id = $room_id;
        $this->request = $request;
        $this->webhookResources = $webhookResources ?:  new \PageBoost\HipChatV2\Resources\Webhooks(null, null, $this->request);
    }

    public function all($startIndex = 0, $maxResult = 100)
    {
        $queryParams = array(
            'start-index' => $startIndex,
            'max-results' => $maxResult,
        );

        $response = $this->request->get('room', array_merge($queryParams, $this->expandQuery()));

        return $this->request->returnResponseObject($response);
    }

    public function get()
    {
        $queryParams = array();
        $room_id_or_name = $this->getId();

        $response = $this->request->get('room/'.$room_id_or_name, array_merge($queryParams, $this->expandQuery()));

        return $this->request->returnResponseObject($response);
    }

    public function create($name, $is_public = true, $guest_access = false, $owner_user_id = null)
    {
        $queryParams = array(
            'name' => $name,
            'privacy' => (($is_public === true) ? 'public' : 'private' ),
            'guest_access' => $guest_access,
        );
        if ($owner_user_id != null) {
            $queryParams['owner_user_id'] = $owner_user_id;
        }

        $response = $this->request->post('room', $queryParams);

        $responseObject = $this->request->returnResponseObject($response);
        if ($responseObject->getResponseCode() == 201) {
            $getData = $responseObject->getData();
            $this->setId($getData['id']);
        }
        return $responseObject;
    }

    public function send($message, $notify = false, $color = HipChat::COLOR_YELLOW, $message_format = HipChat::FORMAT_HTML)
    {
        $queryParams = array(
            'message' => $message,
            'notify' => $notify,
            'color' => $color,
            'message_format' => $message_format,
        );
        $room_id_or_name = $this->getId();

        $response = $this->request->post('room/'.$room_id_or_name.'/notification', $queryParams);

        return $this->request->returnResponseObject($response);
    }

    /**
     * Update room
     * All values are required!
     *
     * @param string $name
     * @param bool $is_public
     * @param bool $is_archived
     * @param bool $is_guest_accessible
     * @param string $topic
     * @param int|string $owner_user_id
     */
    public function update($name, $is_public, $is_archived, $is_guest_accessible, $topic, $owner_user_id)
    {
        $queryParams = array(
            'name' => $name,
            'privacy' => (($is_public === true) ? 'public' : 'private' ),
            'is_archived' => $is_archived,
            'is_guest_accessible' => $is_guest_accessible,
            'topic' => $topic,
            'owner' => array(
                'id' => $owner_user_id,
            ),
        );
        $room_id_or_name = $this->getId();

        $response = $this->request->put('room/'.$room_id_or_name.'', $queryParams);

        return $this->request->returnResponseObject($response);
    }

    public function delete()
    {
        $queryParams = array();
        $room_id_or_name = $this->getId();

        $response = $this->request->delete('room/'.$room_id_or_name, array_merge($queryParams, $this->expandQuery()));

        return $this->request->returnResponseObject($response);
    }

    /**
     * Set room topic
     *
     * @param string $topic
     */
    public function setTopic($topic)
    {
        $queryParams = array(
            'topic' => $topic,
        );
        $room_id_or_name = $this->getId();

        $response = $this->request->put('room/'.$room_id_or_name.'/topic', $queryParams);

        return $this->request->returnResponseObject($response);
    }

    public function history($startIndex = 0, $maxResult = 100)
    {
        $queryParams = array(
            'start-index' => $startIndex,
            'max-results' => $maxResult,
        );
        $room_id_or_name = $this->getId();

        $response = $this->request->get('room/'.$room_id_or_name.'/history', array_merge($queryParams, $this->expandQuery()));

        return $this->request->returnResponseObject($response);
    }

    public function addMember($user_id_or_email)
    {
        $room_id_or_name = $this->getId();
        $response = $this->request->post('room/'.$room_id_or_name.'/member/'.$user_id_or_email);

        $responseObject = $this->request->returnResponseObject($response);
        return $responseObject;
    }

    public function deleteMember($user_id_or_email)
    {
        $room_id_or_name = $this->getId();
        $response = $this->request->delete('room/'.$room_id_or_name.'/member/'.$user_id_or_email);

        $responseObject = $this->request->returnResponseObject($response);
        return $responseObject;
    }

    public function allMembers($startIndex = 0, $maxResult = 100)
    {
        $queryParams = array(
            'start-index' => $startIndex,
            'max-results' => $maxResult,
        );
        $room_id_or_name = $this->getId();

        $response = $this->request->get('room/'.$room_id_or_name.'/member', array_merge($queryParams, $this->expandQuery()));

        return $this->request->returnResponseObject($response);
    }

    public function webhook($hook_id = null)
    {
        $this->webhookResources->setRoomId($this->getId());
        $this->webhookResources->setHookId($hook_id);
        return $this->webhookResources;
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
