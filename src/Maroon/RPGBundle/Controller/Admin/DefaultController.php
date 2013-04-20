<?php

namespace Maroon\RPGBundle\Controller\Admin;

use Maroon\RPGBundle\Modifier\ModifierCollector;
use Maroon\RPGBundle\Util\Calculator;
use Maroon\RPGBundle\Util\Numbers;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response;

/**
 *
 */
class DefaultController extends Controller
{
    /**
     * @Route("/admin", name="admin_in")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirAction()
    {
        return $this->redirect($this->generateUrl('admin_home'));
    }

    /**
     * @Route("/admin/home", name="admin_home")
     * @Template
     */
    public function indexAction()
    {
        return array();
    }

    /**
     * @Route("/admin/test", name="admin_test")
     */
    public function blahAction()
    {
        $calc = Calculator::fromExpr('str * 2 + damage')
            ->value('str', 30)
            ->value('damage', function() { return mt_rand(20, 30); });

        return new Response($calc->result());
        //return new Response(Numbers::guessCoefficient(30, 500));
    }

    /**
     * @Route("/admin/modifier-ref", name="admin_modifier_ref")
     * @Template
     */
    public function modifierRefAction()
    {
        $collector = new ModifierCollector();
        $allMods = $collector->collectAll();

        return ['mods' => $allMods];
    }
}
