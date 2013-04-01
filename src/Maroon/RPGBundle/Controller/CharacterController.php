<?php

namespace Maroon\RPGBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Maroon\RPGBundle\Form\Type\NewCharFormType;

class CharacterController extends Controller
{
    /**
     * @Route("/new-character")
     * @Template
     */
    public function newCharacterAction()
    {
        $em = $this->getDoctrine()->getManager();
        /** @var $races \Maroon\RPGBundle\Entity\Race[] */
        $races = $em->getRepository('MaroonRPGBundle:Race')->findBy(array(), array('name' => 'ASC'));

        $options = array('races' => array());
        foreach ( $races as $race ) {
            $options['races'][$race->getId()] = $race->getName();
        }

        $char = array();
        $form = $this->createForm(new NewCharFormType($options), $char);

        return array('form' => $form->createView(), 'races' => json_encode($races));
    }
}
