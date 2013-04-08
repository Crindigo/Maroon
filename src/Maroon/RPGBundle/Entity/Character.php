<?php

/*
 * This file is part of Maroon (name not final).
 *
 * Maroon is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Maroon is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Maroon.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Maroon\RPGBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Character entity.
 *
 * @ORM\Table(name="rpg_characters")
 * @ORM\Entity(repositoryClass="Maroon\RPGBundle\Repository\CharacterRepository")
 */
class Character
{
    /**
     * @var integer
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="characters")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $user;

    /**
     * @ORM\Column(type="string")
     */
    protected $name;

    /**
     * @var Race
     *
     * @ORM\ManyToOne(targetEntity="Race")
     */
    protected $race;

    /**
     * @var Gender
     *
     * @ORM\ManyToOne(targetEntity="Gender")
     */
    protected $gender;

    /**
     * @var Job
     *
     * @ORM\ManyToOne(targetEntity="Job")
     */
    protected $job;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    protected $level;

    /**
     * @var integer
     *
     * @ORM\Column(type="integer")
     */
    protected $experience;

    /**
     * @var CharStats
     *
     * @ORM\OneToOne(targetEntity="CharStats")
     */
    protected $baseStats;

    /**
     * @var CharStats
     *
     * @ORM\OneToOne(targetEntity="CharStats")
     */
    protected $stats;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Equipment", mappedBy="character")
     */
    protected $equipment;

    public function __construct()
    {
        $this->equipment = new ArrayCollection();
    }

    public function getStat($stat)
    {
        if ( !isset(CharStats::$statAliases[$stat]) ) {
            throw new \InvalidArgumentException('Invalid statistic type');
        }

        $statMethod = 'get' . CharStats::$statAliases[$stat];
        return $this->getStats()->$statMethod();
    }

    public function setStat($stat, $value)
    {
        if ( !isset(CharStats::$statAliases[$stat]) ) {
            throw new \InvalidArgumentException('Invalid statistic type');
        }

        $statMethod = 'set' . CharStats::$statAliases[$stat];
        $this->getStats()->$statMethod($value);

        return $this;
    }

    /**
     * Rebuilds the $stats of this character based on $baseStats and equipment effects
     */
    public function rebuildStats()
    {
        $base = $this->getBaseStats();

        /** @var $equip Equipment */
        foreach ( $this->getEquipment() as $equip ) {
            $item = $equip->getItem();
            $data = $equip->getItemData();
        }
    }

    /**
     * @param CharStats $baseStats
     * @return Character
     */
    public function setBaseStats(CharStats $baseStats)
    {
        $this->baseStats = $baseStats;
        return $this;
    }

    /**
     * @return CharStats
     */
    public function getBaseStats()
    {
        return $this->baseStats;
    }

    /**
     * @param ArrayCollection $equipment
     * @return Character
     */
    public function setEquipment(ArrayCollection $equipment)
    {
        $this->equipment = $equipment;
        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getEquipment()
    {
        return $this->equipment;
    }

    /**
     * @param $experience
     * @return Character
     */
    public function setExperience($experience)
    {
        $this->experience = $experience;
        return $this;
    }

    /**
     * @return int
     */
    public function getExperience()
    {
        return $this->experience;
    }

    /**
     * @param Gender $gender
     * @return Character
     */
    public function setGender(Gender $gender)
    {
        $this->gender = $gender;
        return $this;
    }

    /**
     * @return Gender
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param $level
     * @return Character
     */
    public function setLevel($level)
    {
        $this->level = $level;
        return $this;
    }

    /**
     * @return int
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * @param $name
     * @return Character
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param Job $primaryJob
     * @return Character
     */
    public function setJob(Job $primaryJob)
    {
        $this->job = $primaryJob;
        return $this;
    }

    /**
     * @return Job
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * @param Race $race
     * @return Character
     */
    public function setRace(Race $race)
    {
        $this->race = $race;
        return $this;
    }

    /**
     * @return Race
     */
    public function getRace()
    {
        return $this->race;
    }

    /**
     * @param CharStats $stats
     * @return Character
     */
    public function setStats(CharStats $stats)
    {
        $this->stats = $stats;
        return $this;
    }

    /**
     * @return CharStats
     */
    public function getStats()
    {
        return $this->stats;
    }

    /**
     * @param User $user
     * @return Character
     */
    public function setUser(User $user)
    {
        $this->user = $user;
        return $this;
    }

    /**
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }
}
