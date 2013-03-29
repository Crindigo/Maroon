<?php

namespace Maroon\RPGBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Maroon\RPGBundle\Entity\CharStats
 *
 * @ORM\Table(name="rpg_char_stats")
 * @ORM\Entity
 */
class CharStats
{
    /**
     * @var integer $id
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var integer $hp
     *
     * @ORM\Column(name="hp", type="integer")
     */
    private $hp;

    /**
     * @var integer $maxhp
     *
     * @ORM\Column(name="maxhp", type="integer")
     */
    private $maxhp;

    /**
     * @var integer $mp
     *
     * @ORM\Column(name="mp", type="integer")
     */
    private $mp;

    /**
     * @var integer $maxmp
     *
     * @ORM\Column(name="maxmp", type="integer")
     */
    private $maxmp;

    /**
     * @var integer $attack
     *
     * @ORM\Column(name="attack", type="smallint")
     */
    private $attack;

    /**
     * @var integer $defense
     *
     * @ORM\Column(name="defense", type="smallint")
     */
    private $defense;

    /**
     * @var integer $magic
     *
     * @ORM\Column(name="magic", type="smallint")
     */
    private $magic;

    /**
     * @var integer $magicdef
     *
     * @ORM\Column(name="magicdef", type="smallint")
     */
    private $magicdef;

    /**
     * @var integer $accuracy
     *
     * @ORM\Column(name="accuracy", type="smallint")
     */
    private $accuracy;

    /**
     * @var integer $evasion
     *
     * @ORM\Column(name="evasion", type="smallint")
     */
    private $evasion;

    /**
     * @var integer $speed
     *
     * @ORM\Column(name="speed", type="smallint")
     */
    private $speed;

    /**
     * @var integer $luck
     *
     * @ORM\Column(name="luck", type="smallint")
     */
    private $luck;


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
     * Set hp
     *
     * @param integer $hp
     * @return CharStats
     */
    public function setHp($hp)
    {
        $this->hp = $hp;
    
        return $this;
    }

    /**
     * Get hp
     *
     * @return integer 
     */
    public function getHp()
    {
        return $this->hp;
    }

    /**
     * Set maxhp
     *
     * @param integer $maxhp
     * @return CharStats
     */
    public function setMaxhp($maxhp)
    {
        $this->maxhp = $maxhp;
    
        return $this;
    }

    /**
     * Get maxhp
     *
     * @return integer 
     */
    public function getMaxhp()
    {
        return $this->maxhp;
    }

    /**
     * Set mp
     *
     * @param integer $mp
     * @return CharStats
     */
    public function setMp($mp)
    {
        $this->mp = $mp;
    
        return $this;
    }

    /**
     * Get mp
     *
     * @return integer 
     */
    public function getMp()
    {
        return $this->mp;
    }

    /**
     * Set maxmp
     *
     * @param integer $maxmp
     * @return CharStats
     */
    public function setMaxmp($maxmp)
    {
        $this->maxmp = $maxmp;
    
        return $this;
    }

    /**
     * Get maxmp
     *
     * @return integer 
     */
    public function getMaxmp()
    {
        return $this->maxmp;
    }

    /**
     * Set attack
     *
     * @param integer $attack
     * @return CharStats
     */
    public function setAttack($attack)
    {
        $this->attack = $attack;
    
        return $this;
    }

    /**
     * Get attack
     *
     * @return integer 
     */
    public function getAttack()
    {
        return $this->attack;
    }

    /**
     * Set defense
     *
     * @param integer $defense
     * @return CharStats
     */
    public function setDefense($defense)
    {
        $this->defense = $defense;
    
        return $this;
    }

    /**
     * Get defense
     *
     * @return integer 
     */
    public function getDefense()
    {
        return $this->defense;
    }

    /**
     * Set magic
     *
     * @param integer $magic
     * @return CharStats
     */
    public function setMagic($magic)
    {
        $this->magic = $magic;
    
        return $this;
    }

    /**
     * Get magic
     *
     * @return integer 
     */
    public function getMagic()
    {
        return $this->magic;
    }

    /**
     * Set magicdef
     *
     * @param integer $magicdef
     * @return CharStats
     */
    public function setMagicdef($magicdef)
    {
        $this->magicdef = $magicdef;
    
        return $this;
    }

    /**
     * Get magicdef
     *
     * @return integer 
     */
    public function getMagicdef()
    {
        return $this->magicdef;
    }

    /**
     * Set accuracy
     *
     * @param integer $accuracy
     * @return CharStats
     */
    public function setAccuracy($accuracy)
    {
        $this->accuracy = $accuracy;
    
        return $this;
    }

    /**
     * Get accuracy
     *
     * @return integer 
     */
    public function getAccuracy()
    {
        return $this->accuracy;
    }

    /**
     * Set evasion
     *
     * @param integer $evasion
     * @return CharStats
     */
    public function setEvasion($evasion)
    {
        $this->evasion = $evasion;
    
        return $this;
    }

    /**
     * Get evasion
     *
     * @return integer 
     */
    public function getEvasion()
    {
        return $this->evasion;
    }

    /**
     * Set speed
     *
     * @param integer $speed
     * @return CharStats
     */
    public function setSpeed($speed)
    {
        $this->speed = $speed;
    
        return $this;
    }

    /**
     * Get speed
     *
     * @return integer 
     */
    public function getSpeed()
    {
        return $this->speed;
    }

    /**
     * Set luck
     *
     * @param integer $luck
     * @return CharStats
     */
    public function setLuck($luck)
    {
        $this->luck = $luck;
    
        return $this;
    }

    /**
     * Get luck
     *
     * @return integer 
     */
    public function getLuck()
    {
        return $this->luck;
    }
}
