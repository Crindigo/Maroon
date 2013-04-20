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

        // attack_types:
        //   physical: [physical, blunt, pierce, slash]
        //   magical: [magic, fire, ice, electric, water, earth, wind, holy, shadow, gravity]

        $rootNode
            ->children()
                ->arrayNode('attack_types')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->arrayNode('physical')
                            ->defaultValue(['physical', 'blunt', 'pierce', 'slash'])
                            ->prototype('scalar')->end()
                        ->end()
                        ->arrayNode('magical')
                            ->defaultValue(['magic', 'fire', 'ice', 'electric', 'water', 'earth', 'wind', 'holy', 'shadow', 'gravity'])
                            ->prototype('scalar')->end()
                        ->end()
                    ->end()
                ->end()
                ->arrayNode('base_stats')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->integerNode('hp')->defaultValue(100)->end()
                        ->integerNode('sp')->defaultValue(40)->end()
                        ->integerNode('str')->defaultValue(10)->end()
                        ->integerNode('def')->defaultValue(10)->end()
                        ->integerNode('int')->defaultValue(10)->end()
                        ->integerNode('mdef')->defaultValue(10)->end()
                        ->integerNode('dex')->defaultValue(10)->end()
                        ->integerNode('eva')->defaultValue(10)->end()
                        ->integerNode('meva')->defaultValue(10)->end()
                        ->integerNode('spd')->defaultValue(10)->end()
                        ->integerNode('luck')->defaultValue(10)->end()
                    ->end()
                ->end()
                ->arrayNode('base_coeff')
                    ->addDefaultsIfNotSet()
                    ->children()
                        ->floatNode('hp')->defaultValue(8.494766)->end()
                        ->floatNode('sp')->defaultValue(1.236383)->end()
                        ->floatNode('str')->defaultValue(2.252439)->end()
                        ->floatNode('def')->defaultValue(2.252439)->end()
                        ->floatNode('int')->defaultValue(2.252439)->end()
                        ->floatNode('mdef')->defaultValue(2.252439)->end()
                        ->floatNode('dex')->defaultValue(2.252439)->end()
                        ->floatNode('eva')->defaultValue(0)->end()
                        ->floatNode('meva')->defaultValue(0)->end()
                        ->floatNode('spd')->defaultValue(2.252439)->end()
                        ->floatNode('luck')->defaultValue(2.252439)->end()
            ->end();


        return $treeBuilder;
    }
}
