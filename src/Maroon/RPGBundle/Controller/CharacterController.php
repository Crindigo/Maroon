<?php

namespace Maroon\RPGBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Maroon\RPGBundle\Form\Type\NewCharFormType;
use Maroon\RPGBundle\Entity\Gender;
use Maroon\RPGBundle\Entity\Job;
use Symfony\Component\Form\FormError;

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

        foreach ( $genders as $gender ) {
            $options['genders'][$gender->getId()] = $gender->getName();
        }

        foreach ( $jobs as $job ) {
            $options['jobs'][$job->getId()] = $job->getName();
        }

        $baseStats = $this->container->getParameter('maroon_rpg.base_stats');

        //$this->get('logger')->info(print_r($races[0]->getSelectableGenders(), true));

        $form = $this->createForm(new NewCharFormType($options));

        if ( $this->getRequest()->isMethod('POST') ) {
            $form->bind($this->getRequest());
            if ( $form->isValid() ) {
                $data = $form->getData();
                $valid = true;

                // check to make sure gender and job are available for the chosen race
                if ( !in_array($data['gender'], $genderAvailability[$data['race']]) ) {
                    $form->get('gender')->addError(new FormError('This gender is not valid for the selected race.'));
                    $valid = false;
                }
                if ( !in_array($data['job'], $jobAvailability[$data['race']]) ) {
                    $form->get('job')->addError(new FormError('This job is not valid for the selected race.'));
                    $valid = false;
                }

                if ( $valid ) {
                    // add the character
                    $em->getRepository('MaroonRPGBundle:Character')->createNewCharacter(
                        $data, $baseStats, $this->getUser());

                    $this->get('session')->getFlashBag()->add('success', '<strong>Congratulations!</strong> You\'ve created your first character. To get more, access the Recruitment Center option in the Character menu.');
                    return $this->redirect($this->generateUrl('maroon_rpg_default_index'));
                }
            }
        }



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
