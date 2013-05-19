<?php

namespace Maroon\RPGBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Party
 *
 * @ORM\Table(name="rpg_parties")
 * @ORM\Entity(repositoryClass="Maroon\RPGBundle\Repository\PartyRepository")
 */
class Party
{
    const MAX_PARTY_SIZE = 4;

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
     * @ORM\OneToOne(targetEntity="User", inversedBy="party")
     */
    private $user;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Character", mappedBy="party")
     */
    private $characters;

    /**
     * Party formation. Used to give certain buffs/debuffs to positions in the battle party.
     *
     * @var string
     */
    private $formation;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->characters = new ArrayCollection();
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
     * Set user
     *
     * @param User $user
     * @return Party
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
     * Add characters
     *
     * @param Character $characters
     * @return Party
     */
    public function addCharacter(Character $characters)
    {
        $count = count($this->characters);
        if ( $count < self::MAX_PARTY_SIZE ) {
            $this->characters[] = $characters;
            $characters->setParty($this);
            $characters->setPartyPosition($count + 1);
        }
        return $this;
    }

    /**
     * Remove characters
     *
     * @param Character $characters
     */
    public function removeCharacter(Character $characters)
    {
        $this->characters->removeElement($characters);
        $characters->setParty(null);
        $characters->setPartyPosition(0);
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

    public function getSortedCharacters()
    {
        if ( count($this->characters) <= 1 ) {
            return $this->characters;
        }

        /** @var Character[] $chars */
        $chars = $this->characters->toArray();
        usort($chars, function(Character $a, Character $b) {
            return $a->getPartyPosition() - $b->getPartyPosition();
        });

        return new ArrayCollection($chars);
    }
}