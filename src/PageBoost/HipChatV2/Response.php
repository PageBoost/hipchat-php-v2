<?php
namespace PageBoost\HipChatV2;

use PageBoost\HipChatV2\Contracts\ResponseInterface;

class Response implements ResponseInterface
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
}
