<?php

namespace Maroon\RPGBundle\Model;

use Maroon\RPGBundle\Entity\Item as ItemEntity;

/**
 * Represents an in-game item, this is the user-level item object while the item entity is
 * like a back-end object. Operations for loading/saving items still go through the entity.
 *
 * @package Maroon\RPGBundle\Model
 */
class Item
{
    // (logging a defense formula here before i forget)
    // physical dmg reduction = defense / (10 * enemy_level + defense)
    // at 5000 def against enemy lv 100 results in 84% reduction of damage

    /**
     * @var array
     */
    private $modifiers = array();

    public static function fromEntity(ItemEntity $entity)
    {

    }

    public function getModifiers()
    {
        return $this->modifiers;
    }

    public function getStat($stat)
    {

    }
}