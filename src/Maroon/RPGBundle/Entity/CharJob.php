<?php

namespace Maroon\RPGBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CharJob - tracks job level and experience for characters
 *
 * @ORM\Table(name="rpg_char_jobs")
 * @ORM\Entity
 */
class CharJob
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
     * @ORM\ManyToOne(targetEntity="Character", inversedBy="jobLevels")
     */
    private $character;

    /**
     * @var Job
     *
     * @ORM\ManyToOne(targetEntity="Job")
     */
    private $job;

    /**
     * @var int
     *
     * @ORM\Column(name="level", type="smallint")
     */
    private $level;

    /**
     * @var int
     *
     * @ORM\Column(name="experience", type="integer")
     */
    private $experience;

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
     * Set level
     *
     * @param integer $level
     * @return CharJob
     */
    public function setLevel($level)
    {
        $this->level = $level;
    
        return $this;
    }

    /**
     * Get level
     *
     * @return integer 
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set experience
     *
     * @param integer $experience
     * @return CharJob
     */
    public function setExperience($experience)
    {
        $this->experience = $experience;
    
        return $this;
    }

    /**
     * Get experience
     *
     * @return integer 
     */
    public function getExperience()
    {
        return $this->experience;
    }

    /**
     * Set character
     *
     * @param Character $character
     * @return CharJob
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
     * Set job
     *
     * @param Job $job
     * @return CharJob
     */
    public function setJob(Job $job = null)
    {
        $this->job = $job;
    
        return $this;
    }

    /**
     * Get job
     *
     * @return Job
     */
    public function getJob()
    {
        return $this->job;
    }
}