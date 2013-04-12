<?php

namespace Maroon\RPGBundle\Model;

use Maroon\RPGBundle\Entity\Equipment;
use Maroon\RPGBundle\Entity\ItemType as ItemTypeEntity;

/**
 * Represents a type of item, which is used for grouping. For example: 1-handed swords,
 * rings, leather gloves, could all be item types.
 *
 * @package Maroon\RPGBundle\Model
 */
class ItemType
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $description;

    /**
     * @var array
     */
    private $equippableRaces = array();

    /**
     * The slots that can be chosen for this item type when equipping.
     *
     * @var array
     */
    private $slots = array();

    /**
     * All of the slots this item will consume when equipped. If empty, only consumes the slot it's
     * currently equipped in.
     *
     * @var array
     */
    private $requiredSlots = array();

    /**
     * Statistic modifier if an item of this type is equipped into the off-hand slot.
     *
     * @var float
     */
    private $offHandPenalty = 1.0;

    public static function fromEntity(ItemTypeEntity $entity)
    {

    }

    public function getName()
    {
        return $this->name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getEquippableRaces()
    {
        return $this->equippableRaces;
    }

    public function getSlots()
    {
        return $this->slots;
    }

    public function getRequiredSlots()
    {
        return $this->requiredSlots;
    }

    public function getOffHandPenalty()
    {
        return $this->offHandPenalty;
    }

    public function getStatModifier($slot)
    {
        if ( $slot == Equipment::OFF_HAND ) {
            return $this->getOffHandPenalty();
        }
        return 1.0;
    }
}