<?php

namespace Maroon\RPGBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CharSkill - tracks learned skills for each character, referring to SkillCustom
 *
 * @ORM\Table(name="rpg_char_skills")
 * @ORM\Entity
 */
class CharSkill
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
     * @var Character
     *
     * @ORM\ManyToOne(targetEntity="Character", inversedBy="skills")
     */
    private $character;

    /**
     * @var SkillCustom
     *
     * @ORM\ManyToOne(targetEntity="SkillCustom")
     */
    private $customSkill;

    /**
     * @var int For active skills, the number of times it has been used
     *
     * @ORM\Column(name="timesUsed", type="integer")
     */
    private $timesUsed;

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
     * Set timesUsed
     *
     * @param integer $timesUsed
     * @return CharSkill
     */
    public function setTimesUsed($timesUsed)
    {
        $this->timesUsed = $timesUsed;
    
        return $this;
    }

    /**
     * Get timesUsed
     *
     * @return integer 
     */
    public function getTimesUsed()
    {
        return $this->timesUsed;
    }

    /**
     * Set character
     *
     * @param \Maroon\RPGBundle\Entity\Character $character
     * @return CharSkill
     */
    public function setCharacter(\Maroon\RPGBundle\Entity\Character $character = null)
    {
        $this->character = $character;
    
        return $this;
    }

    /**
     * Get character
     *
     * @return \Maroon\RPGBundle\Entity\Character 
     */
    public function getCharacter()
    {
        return $this->character;
    }

    /**
     * Set customSkill
     *
     * @param \Maroon\RPGBundle\Entity\SkillCustom $customSkill
     * @return CharSkill
     */
    public function setCustomSkill(\Maroon\RPGBundle\Entity\SkillCustom $customSkill = null)
    {
        $this->customSkill = $customSkill;
    
        return $this;
    }

    /**
     * Get customSkill
     *
     * @return \Maroon\RPGBundle\Entity\SkillCustom 
     */
    public function getCustomSkill()
    {
        return $this->customSkill;
    }
}