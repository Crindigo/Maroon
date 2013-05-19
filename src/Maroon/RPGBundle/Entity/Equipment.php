<?php

namespace Maroon\RPGBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Equipment
 *
 * @ORM\Table(name="rpg_equipment")
 * @ORM\Entity(repositoryClass="Maroon\RPGBundle\Repository\EquipmentRepository")
 */
class Equipment
{
    const HEAD = 1;
    const NECK = 2;
    const SHOULDERS = 3;
    const PRIMARY_HAND = 4;
    const OFF_HAND = 5;
    const HANDS = 6;
    const ARMS = 7;
    const FINGER_1 = 8;
    const FINGER_2 = 9;
    const TORSO = 10;
    const WAIST = 11;
    const LEGS = 12;
    const FEET = 13;

    const ITEM_1 = 32;
    const ITEM_2 = 33;
    const ITEM_3 = 34;
    const ITEM_4 = 35;
    const ITEM_5 = 36;

    /**
     * Full list of equipment slots, mapped from constant to name.
     *
     * @var array
     */
    static public $slots = array(
        self::HEAD         => 'Head',
        self::NECK         => 'Neck',
        self::SHOULDERS    => 'Shoulders',
        self::PRIMARY_HAND => 'Primary Hand',
        self::OFF_HAND     => 'Off Hand',
        self::HANDS        => 'Gloves',
        self::ARMS         => 'Arms',
        self::FINGER_1     => 'Ring 1',
        self::FINGER_2     => 'Ring 2',
        self::TORSO        => 'Body',
        self::WAIST        => 'Waist',
        self::LEGS         => 'Legs',
        self::FEET         => 'Feet',

        self::ITEM_1 => 'Item 1',
        self::ITEM_2 => 'Item 2',
        self::ITEM_3 => 'Item 3',
        self::ITEM_4 => 'Item 4',
        self::ITEM_5 => 'Item 5',
    );

    static public function registerSlot($name)
    {
        $next = max(100, max(array_keys(self::$slots)) + 1);
        self::$slots[$next] = $name;
        return $next;
    }

    static public function unregisterSlot($id)
    {
        unset(self::$slots[$id]);
    }

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var Character
     *
     * @ORM\ManyToOne(targetEntity="Character", inversedBy="equipment")
     */
    private $character;

    /**
     * @var int
     *
     * @ORM\Column(name="slot", type="smallint")
     */
    private $slot;

    /**
     * @var Item
     *
     * @ORM\ManyToOne(targetEntity="Item")
     */
    private $item;

    /**
     * @var array
     * @ORM\Column(name="itemData", type="array")
     */
    private $itemData;

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set slot
     *
     * @param integer $slot
     * @throws \InvalidArgumentException
     * @return Equipment
     */
    public function setSlot($slot)
    {
        if ( !isset(self::$slots[$slot]) ) {
            throw new \InvalidArgumentException('Invalid slot type');
        }
        $this->slot = $slot;
    
        return $this;
    }

    /**
     * Get slot
     *
     * @return integer 
     */
    public function getSlot()
    {
        return $this->slot;
    }

    /**
     * Set itemData
     *
     * @param array $itemData
     * @return Equipment
     */
    public function setItemData($itemData)
    {
        $this->itemData = $itemData;
    
        return $this;
    }

    /**
     * Get itemData
     *
     * @return array 
     */
    public function getItemData()
    {
        return $this->itemData;
    }

    /**
     * Set character
     *
     * @param Character $character
     * @return Equipment
     */
    public function setCharacter(Character $character = null)
    {
        $this->character = $character;
    
        return $this;
    }

    /**
     * Get character
     *
     * @return Character
     */
    public function getCharacter()
    {
        return $this->character;
    }

    /**
     * Set item
     *
     * @param Item $item
     * @return Equipment
     */
    public function setItem(Item $item = null)
    {
        $this->item = $item;
    
        return $this;
    }

    /**
     * Get item
     *
     * @return Item
     */
    public function getItem()
    {
        return $this->item;
    }
}