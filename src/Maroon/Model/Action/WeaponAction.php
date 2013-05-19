<?php

namespace Maroon\Model\Action;

use Maroon\Model\Item;

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
