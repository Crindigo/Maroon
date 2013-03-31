<?php

namespace Maroon\RPGBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Yaml\Yaml;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template()
     */
    public function indexAction()
    {
        $yaml = Yaml::parse(<<<'YML'
ArmorEffects.AdjustElementalDamage:
  elements: {Fire: -50, Ice: 25}

ArmorEffects.AdjustStatusVulnerability:
  statuses: {Poison: -25, Silence: 25}
YML
        );
        return array('name' => 'test', 'yml' => print_r($yaml, true));
    }
}
