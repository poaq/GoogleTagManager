<?php

namespace Poaq\GoogleTagManagerBundle\Service;

/**
 * Class GoogleTagManager
 *
 * @package Poaq\GoogleTagManagerBundle\Service
 */
class GoogleTagManager implements GoogleTagManagerInterface
{
    /**
     * @var bool
     */
    private $enabled;

    /**
     * @var string
     */
    private $id;

    /**
     * @var array
     */
    private $data = array();

    /**
     * @var array
     */
    private $push = array();

    /**
     * @param $enabled
     * @param $id
     */
    public function __construct($enabled, $id)
    {
        $this->enabled = (bool)$enabled;
        $this->id = $id;
    }

    /**
     * {@inheritdoc}
     */
    public function addData($key, $value)
    {
        $this->setData($key, $value);
    }

    /**
     * {@inheritdoc}
     */
    public function setData($key, $value)
    {
        $this->data[$key] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function mergeData($key, $value)
    {
        $merge = array();
        if (array_key_exists($key, $this->data)) {
            $merge = $this->data[$key];
        }

        $this->setData($key, array_merge_recursive($merge, $value));
    }

    /**
     * {@inheritdoc}
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * {@inheritdoc}
     */
    public function addPush($value)
    {
        $this->push[] = $value;
    }

    /**
     * {@inheritdoc}
     */
    public function getPush()
    {
        return $this->push;
    }

    /**
     * {@inheritdoc}
     */
    public function hasData()
    {
        return is_array($this->getData())
        && count($this->getData()) > 0;
    }

    /**
     * Reset internal state at the end of the request
     */
    public function reset()
    {
        $this->data = array();
        $this->push = array();
    }
}
