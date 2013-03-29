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
use Symfony\Component\Security\Core\User\UserInterface;
use FOS\UserBundle\Entity\User as BaseUser;

/**
 * User entity. Will also need to track money, selected party, # characters allowed. Maybe 1->many for chars.
 *
 * @ORM\Table(name="rpg_users")
 * @ORM\Entity(repositoryClass="Maroon\RPGBundle\Repository\UserRepository")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\OneToMany(targetEntity="Character", mappedBy="user")
     */
    protected $characters;

    public function __construct()
    {
        parent::__construct();

        $this->characters = new \Doctrine\Common\Collections\ArrayCollection();
    }
}