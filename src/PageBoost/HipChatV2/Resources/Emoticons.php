<?php
namespace PageBoost\HipChatV2\Resources;

use PageBoost\HipChatV2\Contracts\RequestInterface;

class Emoticons extends BaseExpand
{
    protected $request = null;

    protected $id = null;

    public function __construct($id_or_shortcode, RequestInterface $request)
    {
        $this->id = $id_or_shortcode;
        $this->request = $request;
    }

    public function all($startIndex = 0, $maxResult = 100, $type = 'all')
    {
        $queryParams = array(
            'start-index' => $startIndex,
            'max-results' => $maxResult,
            'type' => $type,
        );

        $response = $this->request->get('emoticon', array_merge($queryParams, $this->expandQuery()));

        return $this->request->returnResponseObject($response);
    }

    public function get()
    {
        $queryParams = array();
        $id_or_shortcode = $this->getId();

        $response = $this->request->get('emoticon/'.$id_or_shortcode, array_merge($queryParams, $this->expandQuery()));

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
        return $this;
    }
}
