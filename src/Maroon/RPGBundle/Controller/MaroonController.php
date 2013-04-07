<?php

namespace Maroon\RPGBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class MaroonController extends Controller
{
    private $_entityManager = null;

    protected function em()
    {
        if ( $this->_entityManager === null ) {
            $this->_entityManager = $this->getDoctrine()->getManager();
        }
        return $this->_entityManager;
    }

    protected function repo($name)
    {
        if ( strpos($name, ':') === false ) {
            $name = "MaroonRPGBundle:$name";
        }
        return $this->em()->getRepository($name);
    }

    protected function flash($key, $message)
    {
        return $this->get('session')->getFlashBag()->add($key, $message);
    }
}