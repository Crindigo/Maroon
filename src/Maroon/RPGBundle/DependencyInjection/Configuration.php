<?php

namespace Maroon\RPGBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html#cookbook-bundles-extension-config-class}
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('maroon_rpg');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        $rootNode
            ->children()
                ->arrayNode('base_stats')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->integerNode('hp')->defaultValue(100)->end()
                        ->integerNode('sp')->defaultValue(40)->end()
                        ->integerNode('str')->defaultValue(10)->end()
                        ->integerNode('def')->defaultValue(10)->end()
                        ->integerNode('int')->defaultValue(10)->end()
                        ->integerNode('mdef')->defaultValue(10)->end()
                        ->integerNode('acc')->defaultValue(10)->end()
                        ->integerNode('eva')->defaultValue(10)->end()
                        ->integerNode('meva')->defaultValue(10)->end()
                        ->integerNode('spd')->defaultValue(10)->end()
                        ->integerNode('luck')->defaultValue(10)->end()
                    ->end()
                ->end()
            ->end();


        return $treeBuilder;
    }
}
