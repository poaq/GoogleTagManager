<?php


namespace Poaq\GoogleTagManagerBundle\Twig;

use Symfony\Component\Templating\Helper\HelperInterface;
use Twig\TwigFunction;

use Poaq\GoogleTagManagerBundle\Helper\GoogleTagManagerHelper;
use Poaq\GoogleTagManagerBundle\Helper\GoogleTagManagerHelperInterface;

/**
 * Class GoogleTagManagerExtension
 *
 * @package Xynnn\GoogleTagManagerBundle\Extension
 */
class GoogleTagManagerExtension extends \Twig\Extension\AbstractExtension
{
    const AREA_FULL = 'full';
    const AREA_HEAD = 'head';
    const AREA_BODY = 'body';
    const AREA_BODY_END = 'body_end';

    /**
     * @var GoogleTagManagerHelperInterface
     */
    private $helper;

    /**
     * @param GoogleTagManagerHelperInterface $helper
     */
    public function __construct(GoogleTagManagerHelperInterface $helper)
    {
        $this->helper = $helper;
    }

    /**
     * @return array
     */
    public function getFunctions()
    {
        return array(
            new TwigFunction('google_tag_manager', array($this, 'render'), array(
                'is_safe' => array('html'),
                'needs_environment' => true,
                'deprecated' => true,
            )),
            new TwigFunction('google_tag_manager_body', array($this, 'renderBody'), array(
                'is_safe' => array('html'),
                'needs_environment' => true,
            )),
            new TwigFunction('google_tag_manager_head', array($this, 'renderHead'), array(
                'is_safe' => array('html'),
                'needs_environment' => true,
            )),
            new TwigFunction('google_tag_manager_body_end', array($this, 'renderBodyEnd'), array(
                'is_safe' => array('html'),
                'needs_environment' => true,
            )),
        );
    }

    /**
     * @param \Twig_Environment $twig
     *
     * @deprecated Use `renderHead` and `renderBody`
     *
     * @return string
     */
    public function render(\Twig\Environment $twig)
    {
        return $this->getRenderedTemplate($twig, self::AREA_FULL);
    }

    /**
     * @param \Twig\Environment $twig
     *
     * @return string
     */
    public function renderHead(\Twig\Environment $twig)
    {
        return $this->getRenderedTemplate($twig, self::AREA_HEAD);
    }

    /**
     * @param \Twig\Environment $twig
     *
     * @return string
     */
    public function renderBody(\Twig\Environment $twig)
    {
        return $this->getRenderedTemplate($twig, self::AREA_BODY);
    }

    /**
     * @param \Twig\Environment $twig
     *
     * @return string
     */
    public function renderBodyEnd(\Twig\Environment $twig)
    {
        return $this->getRenderedTemplate($twig, self::AREA_BODY_END);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'google_tag_manager';
    }

    /**
     * @param $area
     * @return string
     */
    private function getTemplate($area)
    {
        switch ($area) {
            case self::AREA_HEAD:
                return 'tagmanager_head';
            case self::AREA_BODY:
                return 'tagmanager_body';
            case self::AREA_BODY_END:
                return 'tagmanager_body_end';
            case self::AREA_FULL:
            default:
                return 'tagmanager';
        }
    }

    /**
     * @param \Twig\Environment $twig
     * @param $area
     * @return string
     */
    private function getRenderedTemplate(\Twig\Environment $twig, $area)
    {
        if (!$this->helper->isEnabled()) {
            return '';
        }

        return $twig->render(
            '@GoogleTagManager/' . $this->getTemplate($area) . '.html.twig', array(
                'id' => $this->helper->getId(),
                'data' => $this->helper->hasData() ? $this->helper->getData() : null,
                'push' => $this->helper->getPush() ? $this->helper->getPush() : null,
            )
        );
    }
}
