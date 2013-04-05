<?php

namespace Maroon\RPGBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Maroon\RPGBundle\Form\Type\NewCharFormType;
use Maroon\RPGBundle\Entity\Gender;
use Maroon\RPGBundle\Entity\Job;

class CharacterController extends Controller
{
    /**
     * @Secure(roles="ROLE_USER")
     * @Route("/new-character")
     * @Template
     */
    public function newCharacterAction()
    {
        if ( $this->getUser()->hasCharacters() ) {
            $this->get('session')->getFlashBag()->add('info', 'Additional characters are gained through recruitment.');
            return $this->redirect($this->generateUrl('maroon_rpg_default_index'));
        }

        $em = $this->getDoctrine()->getManager();
        /** @var $races \Maroon\RPGBundle\Entity\Race[] */
        $races = $em->getRepository('MaroonRPGBundle:Race')->findWithGendersAndJobs();

        /** @var $genders \Maroon\RPGBundle\Entity\Gender[] */
        $genders = $em->getRepository('MaroonRPGBundle:Gender')->findBy([], ['name' => 'ASC']);

        /** @var $jobs \Maroon\RPGBundle\Entity\Job[] */
        $jobs = $em->getRepository('MaroonRPGBundle:Job')->findBy([], ['name' => 'ASC']);

        $options = ['races' => [], 'genders' => [], 'jobs' => []];
        $genderAvailability = [];
        $jobAvailability = [];

        foreach ( $races as $race ) {
            $options['races'][$race->getId()] = $race->getName();
            $genderAvailability[$race->getId()] =
                array_map(function(Gender $g) { return $g->getId(); }, $race->getSelectableGenders());
            $jobAvailability[$race->getId()] =
                array_map(function(Job $j) { return $j->getId(); }, $race->getSelectableJobs());
        }

        //$this->get('logger')->info(print_r($races[0]->getSelectableGenders(), true));

        $char = array();
        $form = $this->createForm(new NewCharFormType($options), $char);

        $baseStats = $this->container->getParameter('maroon_rpg.base_stats');

        return array(
            'form' => $form->createView(),
            'races' => json_encode($races),
            'genders' => json_encode($genders),
            'jobs' => json_encode($jobs),
            'genderChoices' => json_encode($genderAvailability),
            'jobChoices' => json_encode($jobAvailability),
            'baseStats' => json_encode($baseStats),
        );
    }
}
