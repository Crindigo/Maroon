<?php

namespace Maroon\RPGBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Maroon\RPGBundle\Entity\Gender
 *
 * @ORM\Table(name="rpg_genders")
 * @ORM\Entity
 */
class Gender
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
     * @return Gender
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
     * @return Gender
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
     * @return Gender
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
     * @return Gender
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
