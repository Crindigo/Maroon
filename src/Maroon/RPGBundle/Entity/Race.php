<?php

namespace Maroon\RPGBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Maroon\RPGBundle\Validator\Constraints as MaroonAssert;

/**
 * Maroon\RPGBundle\Entity\Race
 *
 * @ORM\Table(name="rpg_races")
 * @ORM\Entity(repositoryClass="Maroon\RPGBundle\Repository\RaceRepository")
 */
class Race implements \JsonSerializable
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
     * @var array $modifiers
     *
     * @ORM\Column(name="modifiers", type="array")
     * @MaroonAssert\Modifier("race")
     */
    private $modifiers;

    /**
     * @var ArrayCollection $selectableGenders
     *
     * @ORM\ManyToMany(targetEntity="Gender")
     * @ORM\JoinTable(name="rpg_races_genders",
     *   joinColumns={ @ORM\JoinColumn(name="race_id", referencedColumnName="id") },
     *   inverseJoinColumns={ @ORM\JoinColumn(name="gender_id", referencedColumnName="id") }
     * )
     */
    private $selectableGenders;

    /**
     * @var ArrayCollection $selectableJobs
     *
     * @ORM\ManyToMany(targetEntity="Job")
     * @ORM\JoinTable(name="rpg_races_jobs",
     *   joinColumns={ @ORM\JoinColumn(name="race_id", referencedColumnName="id") },
     *   inverseJoinColumns={ @ORM\JoinColumn(name="job_id", referencedColumnName="id") }
     * )
     */
    private $selectableJobs;

    public function __construct()
    {
        $this->statsInit = array();
        $this->statsBonus = array();
        $this->modifiers = array();
        $this->selectableGenders = new ArrayCollection();
        $this->selectableJobs = new ArrayCollection();
    }

    public function jsonSerialize()
    {
        return array(
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'statsInit' => $this->statsInit,
            'statsBonus' => $this->statsBonus,
        );
    }

    public function addGender(Gender $gender)
    {
        $this->selectableGenders[] = $gender;
        return $this;
    }

    public function removeGender(Gender $gender)
    {
        $this->selectableGenders->removeElement($gender);
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getSelectableGenders()
    {
        return $this->selectableGenders;
    }

    public function setSelectableGenders(ArrayCollection $genders)
    {
        $this->selectableGenders = $genders;
        return $this;
    }

    public function addJob(Job $job)
    {
        $this->selectableJobs[] = $job;
        return $this;
    }

    public function removeJob(Job $job)
    {
        $this->selectableJobs->removeElement($job);
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getSelectableJobs()
    {
        return $this->selectableJobs;
    }

    public function setSelectableJobs(ArrayCollection $jobs)
    {
        $this->selectableJobs =  $jobs;
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
     * Set name
     *
     * @param string $name
     * @return Race
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
     * @return Race
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
     * Set statsInit
     *
     * @param array $statsInit
     * @return Race
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
     * @return Race
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

    /**
     * Set modifiers
     *
     * @param array $modifiers
     * @return Race
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
     * Add selectableGenders
     *
     * @param \Maroon\RPGBundle\Entity\Gender $selectableGenders
     * @return Race
     */
    public function addSelectableGender(\Maroon\RPGBundle\Entity\Gender $selectableGenders)
    {
        $this->selectableGenders[] = $selectableGenders;
    
        return $this;
    }

    /**
     * Remove selectableGenders
     *
     * @param \Maroon\RPGBundle\Entity\Gender $selectableGenders
     */
    public function removeSelectableGender(\Maroon\RPGBundle\Entity\Gender $selectableGenders)
    {
        $this->selectableGenders->removeElement($selectableGenders);
    }

    /**
     * Add selectableJobs
     *
     * @param \Maroon\RPGBundle\Entity\Job $selectableJobs
     * @return Race
     */
    public function addSelectableJob(\Maroon\RPGBundle\Entity\Job $selectableJobs)
    {
        $this->selectableJobs[] = $selectableJobs;
    
        return $this;
    }

    /**
     * Remove selectableJobs
     *
     * @param \Maroon\RPGBundle\Entity\Job $selectableJobs
     */
    public function removeSelectableJob(\Maroon\RPGBundle\Entity\Job $selectableJobs)
    {
        $this->selectableJobs->removeElement($selectableJobs);
    }
}