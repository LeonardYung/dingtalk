<?php

/*
 * This file is part of the mingyoung/dingtalk.
 *
 * (c) mingyoung <mingyoungcheung@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyDingTalk\Jssdk;

use function EasyDingTalk\Kernel\Support\str_random;
use function EasyDingTalk\Kernel\Support\current_url;

/**
 * Class ConfigBuilder.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 */
class ConfigBuilder
{
    /**
     * @var \EasyDingTalk\Jssdk\Client
     */
    protected $client;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var array
     */
    protected $apiList = [];

    /**
     * @var int
     */
    protected $agentId;

    /**
     * @var int
     */
    protected $type = 0;

    /**
     * @var int
     */
    protected $timestamp;

    /**
     * @var string
     */
    protected $nonce;

    /**
     * ConfigBuilder constructor.
     *
     * @param \EasyDingTalk\Jssdk\Client $client
     */
    public function __construct( $client)
    {
        $this->client = $client;
    }

    /**
     * Set url.
     *
     * @param string $url
     *
     * @return $this
     */
    public function setUrl( $url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url.
     *
     * @return string
     */
    public function getUrl()
    {
        if (is_null($this->url)) {
            $this->url = current_url();
        }

        return $this->url;
    }

    /**
     * @param array $apiList
     *
     * @return $this
     */
    public function useApi( $apiList)
    {
        $this->apiList = $apiList;

        return $this;
    }

    /**
     * @param int $agentId
     *
     * @return $this
     */
    public function ofAgent( $agentId)
    {
        $this->agentId = $agentId;

        return $this;
    }

    /**
     * @param int $type
     *
     * @return $this
     */
    public function setType( $type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @param int $timestamp
     *
     * @return $this
     */
    public function setTimestamp( $timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * @param string $nonce
     *
     * @return $this
     */
    public function setNonce( $nonce)
    {
        $this->nonce = $nonce;

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return [
            'agentId' => $this->agentId,
            'corpId' => $this->client->corpId(),
            'timeStamp' => $timestamp = $this->timestamp ?: time(),
            'nonceStr' => $nonce = $this->nonce ?: str_random(),
            'signature' => $this->client->signature($this->getUrl(), $nonce, $timestamp),
            'type' => $this->type,
            'jsApiList' => $this->apiList,
        ];
    }

    /**
     * @return string
     */
    public function toJson()
    {
        return json_encode($this->toArray());
    }
}
