<?php

namespace Maroon\RPGBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * ItemType
 *
 * @ORM\Table(name="rpg_item_types")
 * @ORM\Entity
 */
class ItemType
{
    const CATEGORY_WEAPON = 'weapon';
    const CATEGORY_ARMOR = 'armor';
    const CATEGORY_ACCESSORY = 'accessory';
    const CATEGORY_USABLE = 'usable';
    const CATEGORY_LOOT = 'loot';
    const CATEGORY_MISC = 'misc';

    static public $categories = [
        self::CATEGORY_WEAPON    => 'Weapons',
        self::CATEGORY_ARMOR     => 'Armors',
        self::CATEGORY_ACCESSORY => 'Accessories',
        self::CATEGORY_USABLE    => 'Usable Items',
        self::CATEGORY_LOOT      => 'Loot',
        self::CATEGORY_MISC      => 'Miscellaneous',
    ];

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(type="string", length=16)
     */
    private $category;


    private $equippableRaces;

    private $slots;

    private $requiredSlots;

    private $offHandPenalty;

    private $damageType;

    public function __construct()
    {
        $this->name = '';
        $this->description = '';
        $this->category = self::CATEGORY_MISC;
        $this->equippableRaces = new ArrayCollection();
        $this->slots = [];
        $this->requiredSlots = [];
        $this->offHandPenalty = 1.0;
        $this->damageType = 'physical';
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }
}