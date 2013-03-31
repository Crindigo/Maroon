<?php

namespace Maroon\RPGBundle\Menu;

use Knp\Menu\FactoryInterface;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\Security\Core\SecurityContext;

class Builder extends ContainerAware
{
    public function frontMenu(FactoryInterface $factory, array $options)
    {
        /** @var $security SecurityContext */
        $security = $this->container->get('security.context');

        $menu = $factory->createItem('root')->setChildrenAttribute('class', 'nav');
        $menu->addChild('Home', array('route' => 'maroon_rpg_default_index'));

        if ( $security->isGranted('ROLE_USER') ) {
            $characters = $menu->addChild('Characters', array('uri' => '#'));
            $characters->addChild('Manage Your Parties', array('uri' => '#'));
            $characters->addChild('Exchange Members', array('uri' => '#'));
            $characters->addChild('Recruitment Center', array('uri' => '#'));
            $characters->addChild('Search Characters', array('uri' => '#'));

            $items = $menu->addChild('Items', array('uri' => '#'));
            $items->addChild('View Inventory', array('uri' => '#'));
            $items->addChild('Inventory Exchange', array('uri' => '#'));
            $items->addChild('Item Crafting', array('uri' => '#'));
            $items->addChild('Item Trading', array('uri' => '#'));

            $battles = $menu->addChild('Battles', array('uri' => '#'));
            $battles->addChild('Active Battles', array('uri' => '#'));
            $battles->addChild('My Battles', array('uri' => '#'));
            $battles->addChild('Challenge Lobby', array('uri' => '#'));
            $battles->addChild('Archives', array('uri' => '#'));

            $world = $menu->addChild('World', array('uri' => '#'));
            $world->addChild('Explore', array('uri' => '#'));
            $world->addChild('Quests', array('uri' => '#'));
            $world->addChild('Your Shops', array('uri' => '#'));

            $library = $menu->addChild('Library', array('uri' => '#'));
            $library->addChild('Job Classes', array('uri' => '#'));
            $library->addChild('Skills', array('uri' => '#'));
            $library->addChild('Items', array('uri' => '#'));
        }

        return $menu;
    }

    public function frontProfileMenu(FactoryInterface $factory, array $options)
    {
        /** @var $security SecurityContext */
        $security = $this->container->get('security.context');
        $menu = $factory->createItem('root')->setChildrenAttribute('class', 'nav pull-right');

        if ( $security->isGranted('ROLE_USER') ) {
            $dropdown = $menu->addChild($security->getToken()->getUsername(), array('uri' => '#'));

            if ( $security->isGranted('ROLE_ADMIN') ) {
                $dropdown->addChild('Administration', array('route' => 'maroon_rpg_admin_default_index'))
                    ->setExtra('icon', 'wrench');
            }
            $dropdown->addChild('My Profile', array('route' => 'fos_user_profile_show'))->setExtra('icon', 'user');
            $dropdown->addChild('Edit Settings', array('route' => 'fos_user_profile_edit'))->setExtra('icon', 'cog');
            $this->addDivider($dropdown);
            $dropdown->addChild('Logout', array('route' => 'fos_user_security_logout'))->setExtra('icon', 'remove');
        } else {
            $menu->addChild('Log in', array('route' => 'fos_user_security_login'));
            $menu->addChild('Sign up', array('route' => 'fos_user_registration_register'));
        }

        return $menu;
    }

    public function adminMenu(FactoryInterface $factory, array $options)
    {
        $menu = $factory->createItem('root')->setChildrenAttribute('class', 'nav');

        $menu->addChild('Dashboard', array('route' => 'maroon_rpg_admin_default_index'));

        $database = $menu->addChild('Database', array('uri' => '#'));
        $database->addChild('Items', array('uri' => '#'));
        $database->addChild('Item Groups', array('uri' => '#'));
        $database->addChild('Skills', array('uri' => '#'));
        $database->addChild('Talents', array('uri' => '#'));
        $database->addChild('Status Effects', array('uri' => '#'));

        $chars = $menu->addChild('Characters', array('uri' => '#'));
        $chars->addChild('Search Users', array('uri' => '#'));
        $chars->addChild('Search Characters', array('uri' => '#'));
        $this->addHeader($chars, 'Customization');
        $chars->addChild('Job Classes', array('uri' => '#'));
        $chars->addChild('Races', array('uri' => '#'));
        $chars->addChild('Genders', array('uri' => '#'));


        $world = $menu->addChild('World', array('uri' => '#'));
        $world->addChild('Locations', array('uri' => '#'));
        $world->addChild('NPCs', array('uri' => '#'));
        $world->addChild('Shops', array('uri' => '#'));

        return $menu;
    }

    public function adminRightMenu(FactoryInterface $factory, array $options)
    {
        // likely not necessary
    }

    protected function addDivider(\Knp\Menu\ItemInterface $item)
    {
        $item->addChild('')->setExtra('divider', true);
    }

    protected function addHeader(\Knp\Menu\ItemInterface $item, $label)
    {
        $item->addChild($label)->setExtra('header', true);
    }
}
