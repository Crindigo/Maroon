<?php

namespace Maroon\RPGBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SkillCustom
 *
 * @ORM\Table(name="rpg_skill_custom")
 * @ORM\Entity(repositoryClass="Maroon\RPGBundle\Repository\SkillCustomRepository")
 */
class SkillCustom
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
     * @var Skill The base skill this is extending.
     *
     * @ORM\ManyToOne(targetEntity="Skill")
     */
    private $skill;

    /**
     * @var string The type of custom skill (job, item, race)
     */
    private $customType;

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
     * Set skill
     *
     * @param Skill $skill
     * @return SkillCustom
     */
    public function setSkill(Skill $skill = null)
    {
        $this->skill = $skill;
    
        return $this;
    }

    /**
     * Get skill
     *
     * @return Skill
     */
    public function getSkill()
    {
        return $this->skill;
    }
}