<?php

namespace Maroon\Model;

use Maroon\RPGBundle\Entity\Item as ItemEntity;
use Maroon\RPGBundle\Modifier\ModifierTrait;

/**
 * Represents an in-game item, this is the user-level item object while the item entity is
 * like a back-end object. Operations for loading/saving items still go through the entity.
 *
 * @package Maroon\RPGBundle\Model
 */
class Item
{
    // (logging a defense formula here before i forget)
    // physical dmg reduction = defense / (30 * enemy_level + defense)
    // at 10000 def against enemy lv 100 results in 77% reduction of damage

    use ModifierTrait;

    /**
     * @var ItemType
     */
    private $itemType;

    private $damageMin;
    private $damageMax;

    public function getModifierType()
    {
        return 'item';
    }

    public static function fromEntity(ItemEntity $entity)
    {

    }

    public function getStat($stat)
    {

    }

    /**
     * @return ItemType
     */
    public function getItemType()
    {
        return $this->itemType;
    }

    /**
     * Returns base weapon damage for the primary damage type.
     *
     * @param Character $character The character using this item, used for proficiency calculation
     * @return int
     */
    public function getWeaponDamage(Character $character = null)
    {
        $proficiency = 1.0;
        if ( $character !== null ) {
            $proficiency = $character->getItemTypeProficiency($this->itemType);
        }

        return $proficiency * mt_rand($this->damageMin, $this->damageMax);
    }
}