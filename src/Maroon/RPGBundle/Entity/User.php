<?php

/*
 * This file is part of Maroon (name not final).
 *
 * Maroon is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Maroon is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Maroon.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Maroon\RPGBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Entity\User as BaseUser;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * User entity. Will also need to track money, selected party, # characters allowed. Maybe 1->many for chars.
 *
 * @ORM\Table(name="rpg_users")
 * @ORM\Entity(repositoryClass="Maroon\RPGBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Character", mappedBy="user")
     */
    protected $characters;

    /**
     * @ORM\Column(type="smallint")
     */
    protected $characterCount;

    /**
     * @var int
     * @ORM\Column(type="integer")
     */
    protected $money;

    /**
     * @var Party
     *
     * @ORM\OneToOne(targetEntity="Party", mappedBy="user")
     */
    protected $party;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="InvEntry", mappedBy="user")
     */
    protected $inventory;

    /**
     * @var int
     *
     * @ORM\Column(type="integer")
     */
    protected $inventoryLimit;

    public function __construct()
    {
        parent::__construct();

        $this->characterCount = 0;
        $this->characters = new ArrayCollection();
        $this->inventory = new ArrayCollection();
        $this->money = 0;
        $this->inventoryLimit = 50;
    }

    public function addCharacter(Character $character)
    {
        $this->characters->add($character);
        $character->setUser($this);
        $this->characterCount++;
    }

    public function removeCharacter(Character $character)
    {
        $this->characters->removeElement($character);
        $character->setUser(null);
        $this->characterCount--;
    }

    public function hasCharacters()
    {
        return $this->characterCount > 0;
    }

    public function getCharacterCount()
    {
        return $this->characterCount;
    }

    public function getMoney()
    {
        return $this->money;
    }

    public function setMoney($money)
    {
        $this->money = $money;
        return $this;
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
     * Set characterCount
     *
     * @param integer $characterCount
     * @return User
     */
    public function setCharacterCount($characterCount)
    {
        $this->characterCount = $characterCount;
    
        return $this;
    }

    /**
     * Get characters
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCharacters()
    {
        return $this->characters;
    }

    /**
     * Set party
     *
     * @param Party $party
     * @return User
     */
    public function setParty(Party $party = null)
    {
        $this->party = $party;
    
        return $this;
    }

    /**
     * Get party
     *
     * @return Party
     */
    public function getParty()
    {
        return $this->party;
    }

    /**
     * Add inventory
     *
     * @param InvEntry $inventory
     * @return User
     */
    public function addInventory(InvEntry $inventory)
    {
        $this->inventory[] = $inventory;
    
        return $this;
    }

    /**
     * Remove inventory
     *
     * @param InvEntry $inventory
     */
    public function removeInventory(InvEntry $inventory)
    {
        $this->inventory->removeElement($inventory);
    }

    /**
     * Get inventory
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getInventory()
    {
        return $this->inventory;
    }

    /**
     * Set inventoryLimit
     *
     * @param integer $inventoryLimit
     * @return User
     */
    public function setInventoryLimit($inventoryLimit)
    {
        $this->inventoryLimit = $inventoryLimit;
    
        return $this;
    }

    /**
     * Get inventoryLimit
     *
     * @return integer 
     */
    public function getInventoryLimit()
    {
        return $this->inventoryLimit;
    }
}