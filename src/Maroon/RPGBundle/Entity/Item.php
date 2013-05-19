<?php

namespace Maroon\RPGBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Maroon\RPGBundle\Validator\Constraints as MaroonAssert;

/**
 * Item
 *
 * @ORM\Table(name="rpg_items")
 * @ORM\Entity(repositoryClass="Maroon\RPGBundle\Repository\ItemRepository")
 */
class Item
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var ItemType
     *
     * @ORM\ManyToOne(targetEntity="ItemType")
     */
    private $itemType;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var int The max stack size of the item in the party's inventory.
     *
     * @ORM\Column(name="stackSize", type="smallint")
     */
    private $stackSize;

    /**
     * @var array $modifiers
     *
     * @ORM\Column(name="modifiers", type="array")
     * @MaroonAssert\Modifier("item")
     */
    private $modifiers;

    public function __construct()
    {
        $this->stackSize = 1;
        $this->modifiers = array();
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

    /**
     * Set name
     *
     * @param string $name
     * @return Item
     */
    public function setName($name)
    {
        $this->name = $name;
    
        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return Item
     */
    public function setDescription($description)
    {
        $this->description = $description;
    
        return $this;
    }

    /**
     * Get description
     *
     * @return string 
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set stackSize
     *
     * @param integer $stackSize
     * @return Item
     */
    public function setStackSize($stackSize)
    {
        $this->stackSize = $stackSize;
    
        return $this;
    }

    /**
     * Get stackSize
     *
     * @return integer 
     */
    public function getStackSize()
    {
        return $this->stackSize;
    }

    /**
     * Set modifiers
     *
     * @param array $modifiers
     * @return Item
     */
    public function setModifiers($modifiers)
    {
        $this->modifiers = $modifiers;
    
        return $this;
    }

    /**
     * Get modifiers
     *
     * @return array 
     */
    public function getModifiers()
    {
        return $this->modifiers;
    }

    /**
     * Set itemType
     *
     * @param ItemType $itemType
     * @return Item
     */
    public function setItemType(ItemType $itemType = null)
    {
        $this->itemType = $itemType;
    
        return $this;
    }

    /**
     * Get itemType
     *
     * @return ItemType
     */
    public function getItemType()
    {
        return $this->itemType;
    }
}