<?php

namespace Maroon\RPGBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Maroon\RPGBundle\Entity\Job
 *
 * @ORM\Table(name="rpg_jobs")
 * @ORM\Entity(repositoryClass="Maroon\RPGBundle\Repository\JobRepository")
 */
class Job
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
     * @var string $name
     *
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string $description
     *
     * @ORM\Column(name="description", type="text")
     */
    private $description;

    /**
     * @var array $requirements
     *
     * @ORM\Column(name="requirements", type="array")
     */
    private $requirements;

    /**
     * @var array $equippableGroups
     *
     * @ORM\Column(name="equippableGroups", type="array")
     */
    private $equippableGroups;

    /**
     * @var array $statsInit
     *
     * @ORM\Column(name="statsInit", type="array")
     */
    private $statsInit;

    /**
     * @var array $statsBonus
     *
     * @ORM\Column(name="statsBonus", type="array")
     */
    private $statsBonus;


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
     * @return Job
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
     * @return Job
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
     * Set requirements
     *
     * @param array $requirements
     * @return Job
     */
    public function setRequirements($requirements)
    {
        $this->requirements = $requirements;
    
        return $this;
    }

    /**
     * Get requirements
     *
     * @return array
     */
    public function getRequirements()
    {
        return $this->requirements;
    }

    /**
     * Set equippableGroups
     *
     * @param array $equippableGroups
     * @return Job
     */
    public function setEquippableGroups($equippableGroups)
    {
        $this->equippableGroups = $equippableGroups;
    
        return $this;
    }

    /**
     * Get equippableGroups
     *
     * @return array
     */
    public function getEquippableGroups()
    {
        return $this->equippableGroups;
    }

    /**
     * Set statsInit
     *
     * @param array $statsInit
     * @return Job
     */
    public function setStatsInit($statsInit)
    {
        $this->statsInit = $statsInit;
    
        return $this;
    }

    /**
     * Get statsInit
     *
     * @return array
     */
    public function getStatsInit()
    {
        return $this->statsInit;
    }

    /**
     * Set statsBonus
     *
     * @param array $statsBonus
     * @return Job
     */
    public function setStatsBonus($statsBonus)
    {
        $this->statsBonus = $statsBonus;
    
        return $this;
    }

    /**
     * Get statsBonus
     *
     * @return array
     */
    public function getStatsBonus()
    {
        return $this->statsBonus;
    }
}
