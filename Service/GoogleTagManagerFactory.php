<?php


namespace Poaq\GoogleTagManagerBundle\Service;

use Symfony\Component\DependencyInjection\ContainerAwareTrait;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class GoogleTagManagerFactory
 *
 * @package Xynnn\GoogleTagManagerBundle\Service
 */
class GoogleTagManagerFactory
{
    use ContainerAwareTrait;

    /**
     * @return ContainerInterface
     */
    private function getContainer()
    {
        return $this->container;
    }

    /**
     * @return GoogleTagManagerInterface
     */
    public function create()
    {
        $container = $this->getContainer();

        $enabled = $container->getParameter('google_tag_manager.enabled');
        $id = $container->getParameter('google_tag_manager.id');

        $service = new GoogleTagManager($enabled, $id);

        return $service;
    }
}
