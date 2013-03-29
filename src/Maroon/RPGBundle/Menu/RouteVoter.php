<?php

namespace Maroon\RPGBundle\Menu;

use Knp\Menu\Silex\Voter\RouteVoter as BaseRouteVoter;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * {@inheritdoc}
 */
class RouteVoter extends BaseRouteVoter
{
    public function __construct(ContainerInterface $container)
    {
        $this->setRequest($container->get('request'));
    }
}
