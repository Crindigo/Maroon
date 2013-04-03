<?php

namespace Maroon\RPGBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\HttpFoundation\Response;
use Maroon\RPGBundle\Entity\Gender;
use Maroon\RPGBundle\Entity\Race;

class DefaultController extends Controller
{
    /**
     * @Route("/")
     * @Template
     */
    public function indexAction()
    {
        $redis = $this->get('predis.client');
        $tk = $redis->get('testkey');

        $yaml = Yaml::parse(<<<'YML'
ArmorEffects.AdjustElementalDamage:
  elements: {Fire: -50, Ice: 25}

ArmorEffects.AdjustStatusVulnerability:
  statuses: {Poison: -25, Silence: 25}
YML
        );
        return array('name' => 'test', 'yml' => $tk . ' ' . print_r($yaml, true));
    }

    /**
     * @Route("/make-race")
     */
    public function makeRaceAction()
    {
        $em = $this->getDoctrine()->getManager();

        $male = $em->getRepository('MaroonRPGBundle:Gender')->findOneBy(array('name' => 'Male'));
        $female = $em->getRepository('MaroonRPGBundle:Gender')->findOneBy(array('name' => 'Female'));

        $race = new Race();
        $race
            ->setName('Dwarf')
            ->setDescription('Dwarves are short in stature but offer improved physical attributes over other races.')
            ->setStatsBonus(array('hp' => 3, 'atk' => 1, 'def' => 1))
            ->setStatsInit(array('hp' => 15, 'atk' => 5, 'def' => 5))
            ->addGender($male)
            ->addGender($female);

        $em->persist($race);
        //$em->flush();

        return new Response('hello there');
    }
}
