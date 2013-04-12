<?php

namespace Maroon\RPGBundle\DependencyInjection;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\Loader;

/**
 * This is the class that loads and manages your bundle configuration
 *
 * To learn more see {@link http://symfony.com/doc/current/cookbook/bundles/extension.html}
 */
class MaroonRPGExtension extends Extension
{
    /**
     * {@inheritDoc}
     */
    public function load(array $configs, ContainerBuilder $container)
    {
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        $loader = new Loader\XmlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('services.xml');

        //$ymlLoader = new Loader\YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        //$ymlLoader->load('maroon.yml');

        //foreach ( $config['base_stats'] as $stat => $value ) {
        //    $container->setParameter('maroon_rpg.base_stats.' . $stat, $value);
        //}

        $container->setParameter('maroon_rpg.base_stats', $config['base_stats']);
        $container->setParameter('maroon_rpg.attack_types.physical', $config['attack_types']['physical']);
        $container->setParameter('maroon_rpg.attack_types.magical', $config['attack_types']['magical']);
    }
}
