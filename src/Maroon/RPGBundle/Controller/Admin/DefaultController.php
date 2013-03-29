<?php

namespace Maroon\RPGBundle\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 *
 */
class DefaultController extends Controller
{
    /**
     * @Route("/admin")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirAction()
    {
        return $this->redirect($this->generateUrl('maroon_rpg_admin_default_index'));
    }

    /**
     * @Route("/admin/home")
     * @Template
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/admin/test")
     */
    public function blahAction()
    {
        return new \Symfony\Component\HttpFoundation\Response("Is this secure?");
    }
}
