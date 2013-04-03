<?php

namespace Maroon\RPGBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

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
     * @var ArrayCollection $selectableGenders
     *
     * @ORM\ManyToMany(targetEntity="Gender")
     * @ORM\JoinTable(name="rpg_races_genders",
     *   joinColumns={ @ORM\JoinColumn(name="race_id", referencedColumnName="id") },
     *   inverseJoinColumns={ @ORM\JoinColumn(name="gender_id", referencedColumnName="id") }
     * )
     */
    private $selectableGenders;

    public function __construct()
    {
        $this->statsInit = array();
        $this->statsBonus = array();
        $this->selectableGenders = new ArrayCollection();
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
     * @return Gender[]
     */
    public function getSelectableGenders()
    {
        return $this->selectableGenders->toArray();
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
}
