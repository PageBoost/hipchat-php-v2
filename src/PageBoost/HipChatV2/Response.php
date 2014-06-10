<?php
namespace PageBoost\HipChatV2;

use ArrayAccess;
use PageBoost\HipChatV2\Contracts\ResponseInterface;

class Response implements ResponseInterface, ArrayAccess
{
    protected $rateLimit;
    protected $rateRemaining;
    protected $rateReset;
    protected $data;
    protected $responseCode;

    public function __construct()
    {

    }

    /**
     * @return mixed
     */
    public function getRateReset()
    {
        return $this->rateReset;
    }

    /**
     * @param mixed $rateReset
     */
    public function setRateReset($rateReset)
    {
        $this->rateReset = $rateReset;
    }

    /**
     * @return mixed
     */
    public function getRateRemaining()
    {
        return $this->rateRemaining;
    }

    /**
     * @param mixed $rateRemaining
     */
    public function setRateRemaining($rateRemaining)
    {
        $this->rateRemaining = $rateRemaining;
    }

    /**
     * @return mixed
     */
    public function getRateLimit()
    {
        return $this->rateLimit;
    }

    /**
     * @param mixed $rateLimit
     */
    public function setRateLimit($rateLimit)
    {
        $this->rateLimit = $rateLimit;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @param mixed $responseCode
     */
    public function setResponseCode($responseCode)
    {
        $this->responseCode = $responseCode;
    }

    /**
     * @return mixed
     */
    public function getResponseCode()
    {
        return $this->responseCode;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Whether a offset exists
     *
     * @link http://php.net/manual/en/arrayaccess.offsetexists.php
     * @param mixed $offset <p>
     *                      An offset to check for.
     *                      </p>
     * @return boolean true on success or false on failure.
     *                      </p>
     *                      <p>
     *                      The return value will be casted to boolean if non-boolean was returned.
     */
    public function offsetExists($offset)
    {
        return isset($this->data[$offset]);
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to retrieve
     *
     * @link http://php.net/manual/en/arrayaccess.offsetget.php
     * @param mixed $offset <p>
     *                      The offset to retrieve.
     *                      </p>
     * @return mixed Can return all value types.
     */
    public function offsetGet($offset)
    {
        return isset($this->data[$offset]) ? $this->data[$offset] : null;
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to set
     *
     * @link http://php.net/manual/en/arrayaccess.offsetset.php
     * @param mixed $offset <p>
     *                      The offset to assign the value to.
     *                      </p>
     * @param mixed $value  <p>
     *                      The value to set.
     *                      </p>
     * @return void
     */
    public function offsetSet($offset, $value)
    {
        if (is_null($offset)) {
            $this->data[] = $value;
        } else {
            $this->data[$offset] = $value;
        }
    }

    /**
     * (PHP 5 &gt;= 5.0.0)<br/>
     * Offset to unset
     *
     * @link http://php.net/manual/en/arrayaccess.offsetunset.php
     * @param mixed $offset <p>
     *                      The offset to unset.
     *                      </p>
     * @return void
     */
    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }
}
