<?php

namespace Poaq\GoogleTagManagerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * Class Configuration
 *
 * @package Xynnn\GoogleTagManagerBundle\DependencyInjection
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritdoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('google_tag_manager');

        if (method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $rootNode = $treeBuilder->root('google_tag_manager');
        }

        $rootNode
            ->children()
                ->booleanNode('enabled')->end()
                ->scalarNode('id')->end()
                ->booleanNode('autoAppend')->defaultFalse()->end()
            ->end();

        return $treeBuilder;
    }
}
