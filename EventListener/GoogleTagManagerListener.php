<?php

namespace Poaq\GoogleTagManagerBundle\EventListener;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpKernel\Event\ResponseEvent;
use Poaq\GoogleTagManagerBundle\Twig\GoogleTagManagerExtension;

/**
 * Class GoogleTagManagerListener
 *
 * @package Xynnn\GoogleTagManagerBundle\EventListener
 */
class GoogleTagManagerListener
{
    /**
     * @var \Twig\Environment
     */
    private $environment;

    /**
     * @var GoogleTagManagerExtension
     */
    private $extension;

    /**
     * @var bool
     */
    private $autoAppend;

    /**
     * @param \Twig_Environment $environment
     * @param GoogleTagManagerExtension $extension
     * @param bool $autoAppend
     */
    public function __construct(\Twig\Environment $environment, GoogleTagManagerExtension $extension, $autoAppend)
    {
        $this->environment = $environment;
        $this->extension = $extension;
        $this->autoAppend = (bool)$autoAppend;
    }

    /**
     * @param FilterResponseEvent $event
     *
     * @return bool
     */
    public function onKernelResponse(ResponseEvent $event)
    {
        if (!$this->allowRender($event)) {
            return false;
        }

        $response = $event->getResponse();

        // Render the GTM Twig template for after <head>
        $templateHead = $this->extension->renderHead($this->environment);

        // render the GTM Twig template for after <body>
        $templateBody = $this->extension->renderBody($this->environment);

        // render pushes before </body>
        $templateBeforeBodyEnd = $this->extension->renderBodyEnd($this->environment);

        // Insert container immediately after opening <head> or <body>
        $content = preg_replace(array(
            '/<head\b[^>]*>/',
            '/<body\b[^>]*>/',
            '/<\/body\b[^>]*>/',
        ), array(
            "$0" . $templateHead,
            "$0" . $templateBody,
            $templateBeforeBodyEnd . "$0",
        ), $response->getContent(), 1);

        // update the response
        $response->setContent($content);

        return true;
    }

    /**
     * @param FilterResponseEvent $event
     *
     * @return bool
     */
    private function allowRender(ResponseEvent $event)
    {
        // not configured to append automatically
        if (!$this->autoAppend) {
            return false;
        }

        // only append to HTML responses
        if (!in_array($event->getResponse()->headers->get('content-type'), array('text/html', null))) {
            return false;
        }

        // only append to master request
        if (!$event->isMasterRequest()) {
            return false;
        }

        return true;
    }
}
