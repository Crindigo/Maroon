<?php

namespace Maroon\RPGBundle\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Maroon\RPGBundle\Entity\Job;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Yaml\Yaml;
use Symfony\Component\HttpFoundation\Response;
use Maroon\RPGBundle\Entity\Gender;
use Maroon\RPGBundle\Entity\Race;

class DefaultController extends MaroonController
{
    /**
     * @Route("/")
     * @Template
     */
    public function indexAction()
    {
        $yaml = Yaml::dump(['Armor.AdjustDamageType' => ['fire' => -50, 'ice' => 25], 'Armor.AdjustStatusVulnerability' => ['poison' => -25, 'silence' => 25]]);
        return array('name' => 'test', 'yml' => $yaml);
    }

    /**
     * @Route("/make-race")
     */
    public function makeRaceAction()
    {
        $human = $this->repo('Race')->findOneBy(array('name' => 'Human'));
        $dwarf = $this->repo('Race')->findOneBy(array('name' => 'Dwarf'));

        $job = new Job();
        $job
            ->setName('Mage')
            ->setDescription('Job specializing in wielding staves and casting a variety of magic spells.')
            ->setEquippableGroups(array())
            ->setRequirements(array())
            ->setStatsInit(array('sp' => 15, 'int' => 10, 'mdef' => 10))
            ->setStatsBonus(array('sp' => 3, 'int' => 2, 'mdef' => 2));

        $human->addJob($job);
        $dwarf->addJob($job);

        $this->em()->persist($job);
        //$this->em()->flush();

        return new Response('hello there');
    }
}
