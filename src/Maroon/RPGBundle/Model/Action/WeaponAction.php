<?php

namespace Maroon\RPGBundle\Model\Action;

use Maroon\RPGBundle\Model\Item;

class WeaponAction extends AbstractAction
{
    /**
     * @var Item
     */
    private $weapon;

    public function getType()
    {
        return 'weapon';
    }

    /**
     * @return Item
     */
    public function getWeapon()
    {
        return $this->weapon;
    }
}
