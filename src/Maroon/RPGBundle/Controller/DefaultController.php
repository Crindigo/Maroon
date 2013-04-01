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
        $yaml = Yaml::parse(<<<'YML'
ArmorEffects.AdjustElementalDamage:
  elements: {Fire: -50, Ice: 25}

ArmorEffects.AdjustStatusVulnerability:
  statuses: {Poison: -25, Silence: 25}
YML
        );
        return array('name' => 'test', 'yml' => print_r($yaml, true));
    }

    /**
     * @Route("/make-race")
     */
    public function makeRaceAction()
    {
        $male = new Gender();
        $male
            ->setName('Male')
            ->setDescription('Male characters receive a small boost to physical-related statistics.')
            ->setStatsBonus(array('hp' => 3, 'str' => 1, 'def' => 1))
            ->setStatsInit(array('hp' => 10, 'str' => 3, 'def' => 3));

        $female = new Gender();
        $female
            ->setName('Female')
            ->setDescription('Female characters receive a small boost to magical-related statistics.')
            ->setStatsBonus(array('mp' => 2, 'int' => 1, 'mdef' => 1))
            ->setStatsInit(array('mp' => 6, 'int' => 3, 'mdef' => 3));

        $race = new Race();
        $race
            ->setName('Human')
            ->setDescription('Humans are generally an all-round class. They can use most equipment and access '
                . 'most classes, but offer no special perks.')
            ->setStatsBonus(array())
            ->setStatsInit(array())
            ->addGender($male)
            ->addGender($female);

        $em = $this->getDoctrine()->getManager();
        $em->persist($male);
        $em->persist($female);
        $em->persist($race);
        //$em->flush();

        return new Response('hello there');
    }
}
