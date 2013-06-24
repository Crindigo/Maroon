<?php

namespace Maroon\RPGBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * InvEntry
 *
 * @ORM\Table(name="rpg_inventory")
 * @ORM\Entity
 */
class InvEntry
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
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="inventory")
     */
    private $user;

    /**
     * @var Item
     *
     * @ORM\ManyToOne(targetEntity="Item")
     */
    private $item;

    /**
     * @var integer
     *
     * @ORM\Column(name="quantity", type="smallint")
     */
    private $quantity;

    /**
     * @var array
     *
     * @ORM\Column(name="itemData", type="array")
     */
    private $itemData;

    public function __construct()
    {
        $this->itemData = array();
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
     * Set quantity
     *
     * @param integer $quantity
     * @return InvEntry
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    
        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set itemData
     *
     * @param array $itemData
     * @return InvEntry
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
     * Set user
     *
     * @param User $user
     * @return InvEntry
     */
    public function setUser(User $user = null)
    {
        $this->user = $user;
    
        return $this;
    }

    /**
     * Get user
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set item
     *
     * @param Item $item
     * @return InvEntry
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