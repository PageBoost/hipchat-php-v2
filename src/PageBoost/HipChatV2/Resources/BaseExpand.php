<?php
namespace PageBoost\HipChatV2\Resources;

abstract class BaseExpand
{
    protected $expand = null;

    public function expand($properties = array())
    {
        if (is_array($properties)) {
            $this->expand = implode(',', $properties);
            return $this;
        }

        $this->expand = $properties;
        return $this;
    }

    public function expandQuery()
    {
        if ($this->expand === null) {
            return array();
        }

        return array('expand'=>$this->expand);
    }
}
