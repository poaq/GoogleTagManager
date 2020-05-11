<?php

namespace Poaq\GoogleTagManagerBundle\Helper;

use Symfony\Component\Templating\Helper\Helper;
use Poaq\GoogleTagManagerBundle\Service\GoogleTagManagerInterface;

/**
 * Class GoogleTagManagerHelper
 *
 * @package Xynnn\GoogleTagManagerBundle\Helper
 */
class GoogleTagManagerHelper extends Helper implements GoogleTagManagerHelperInterface
{
    /**
     * @var GoogleTagManagerInterface
     */
    private $service;

    /**
     * @param GoogleTagManagerInterface $service
     */
    public function __construct(GoogleTagManagerInterface $service)
    {
        $this->service = $service;
    }

    /**
     * {@inheritdoc}
     */
    public function isEnabled()
    {
        return $this->service->isEnabled();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->service->getId();
    }

    /**
     * {@inheritdoc}
     */
    public function getData()
    {
        return $this->service->getData();
    }

    /**
     * {@inheritdoc}
     */
    public function hasData()
    {
        return $this->service->hasData();
    }

    /**
     * {@inheritdoc}
     */
    public function getPush()
    {
        return $this->service->getPush();
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'google_tag_manager';
    }
}
