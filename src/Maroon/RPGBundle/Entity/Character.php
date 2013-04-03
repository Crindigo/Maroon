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

use Doctrine\ORM\Mapping as ORM;

/**
 * Character entity.
 *
 * @ORM\Table(name="rpg_characters")
 * @ORM\Entity(repositoryClass="Maroon\RPGBundle\Repository\CharacterRepository")
 */
class Character
{
    static public $statAliases = array(
        // hp, mp, maxhp, maxmp, luck not included
        'atk'  => 'Attack',
        'def'  => 'Defense',
        'mag'  => 'Magic',
        'mdef' => 'MagicDefense',
        'acc'  => 'Accuracy',
        'eva'  => 'Evasion',
        'meva' => 'MagicEvasion',
        'spd'  => 'Speed',
    );

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
    protected $primaryJob;

    /**
     * @var Job
     *
     * @ORM\ManyToOne(targetEntity="Job")
     */
    protected $secondaryJob;

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
     *
     */
    protected $equipment;


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
     * @param $equipment
     * @return Character
     */
    public function setEquipment($equipment)
    {
        $this->equipment = $equipment;
        return $this;
    }

    /**
     * @return mixed
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
    public function setPrimaryJob(Job $primaryJob)
    {
        $this->primaryJob = $primaryJob;
        return $this;
    }

    /**
     * @return Job
     */
    public function getPrimaryJob()
    {
        return $this->primaryJob;
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
     * @param Job $secondaryJob
     * @return Character
     */
    public function setSecondaryJob(Job $secondaryJob)
    {
        $this->secondaryJob = $secondaryJob;
        return $this;
    }

    /**
     * @return Job
     */
    public function getSecondaryJob()
    {
        return $this->secondaryJob;
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
