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
    static public $statAliases = array(
        'hp'    => 'Hp',
        'maxhp' => 'Maxhp',
        'sp'    => 'Sp',
        'maxsp' => 'Maxsp',

        'str'  => 'Strength',
        'def'  => 'Defense',
        'int'  => 'Intelligence',
        'mdef' => 'MagicDefense',

        'acc'  => 'Accuracy',
        'eva'  => 'Evasion',
        'meva' => 'MagicEvasion',
        'spd'  => 'Speed',
        'luck' => 'Luck',
    );

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
     * @var integer $sp
     *
     * @ORM\Column(name="sp", type="integer")
     */
    private $sp;

    /**
     * @var integer $maxsp
     *
     * @ORM\Column(name="maxsp", type="integer")
     */
    private $maxsp;

    /**
     * @var integer $attack
     *
     * @ORM\Column(name="strength", type="smallint")
     */
    private $strength;

    /**
     * @var integer $defense
     *
     * @ORM\Column(name="defense", type="smallint")
     */
    private $defense;

    /**
     * @var integer $magic
     *
     * @ORM\Column(name="intelligence", type="smallint")
     */
    private $intelligence;

    /**
     * @var integer $magicdef
     *
     * @ORM\Column(name="magicdef", type="smallint")
     */
    private $magicDefense;

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
     * @var integer $magicEvasion
     *
     * @ORM\Column(name="magicevasion", type="smallint")
     */
    private $magicEvasion;

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

    public function get($stat)
    {
        if ( !isset(self::$statAliases[$stat]) ) {
            throw new \InvalidArgumentException('Invalid statistic type');
        }

        $statMethod = 'get' . self::$statAliases[$stat];
        return $this->$statMethod();
    }

    public function set($stat, $value)
    {
        if ( !isset(self::$statAliases[$stat]) ) {
        throw new \InvalidArgumentException('Invalid statistic type');
        }

        $statMethod = 'set' . self::$statAliases[$stat];
        $this->$statMethod($value);
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
     * Set sp
     *
     * @param integer $sp
     * @return CharStats
     */
    public function setSp($sp)
    {
        $this->sp = $sp;
    
        return $this;
    }

    /**
     * Get sp
     *
     * @return integer 
     */
    public function getSp()
    {
        return $this->sp;
    }

    /**
     * Set maxsp
     *
     * @param integer $maxsp
     * @return CharStats
     */
    public function setMaxsp($maxsp)
    {
        $this->maxsp = $maxsp;
    
        return $this;
    }

    /**
     * Get maxsp
     *
     * @return integer 
     */
    public function getMaxsp()
    {
        return $this->maxsp;
    }

    /**
     * Set strength
     *
     * @param integer $strength
     * @return CharStats
     */
    public function setStrength($strength)
    {
        $this->strength = $strength;
    
        return $this;
    }

    /**
     * Get strength
     *
     * @return integer 
     */
    public function getStrength()
    {
        return $this->strength;
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
     * Set intelligence
     *
     * @param integer $intelligence
     * @return CharStats
     */
    public function setIntelligence($intelligence)
    {
        $this->intelligence = $intelligence;
    
        return $this;
    }

    /**
     * Get intelligence
     *
     * @return integer 
     */
    public function getIntelligence()
    {
        return $this->intelligence;
    }

    /**
     * Set magicdef
     *
     * @param integer $magicdef
     * @return CharStats
     */
    public function setMagicDefense($magicdef)
    {
        $this->magicDefense = $magicdef;
    
        return $this;
    }

    /**
     * Get magicdef
     *
     * @return integer 
     */
    public function getMagicDefense()
    {
        return $this->magicDefense;
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
     * Set magic evasion
     *
     * @param integer $evasion
     * @return CharStats
     */
    public function setMagicEvasion($evasion)
    {
        $this->magicEvasion = $evasion;

        return $this;
    }

    /**
     * Get magic evasion
     *
     * @return integer
     */
    public function getMagicEvasion()
    {
        return $this->magicEvasion;
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
