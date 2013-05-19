<?php

namespace Maroon\RPGBundle\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NoResultException;
use Maroon\RPGBundle\Entity\CharStats;
use Maroon\RPGBundle\Entity\Character;
use Maroon\RPGBundle\Entity\Party;
use Maroon\RPGBundle\Entity\User;

class CharacterRepository extends EntityRepository
{
    /**
     * Finds a character and includes race/gender/current job information in the result.
     *
     * @param $id
     * @return Character|null
     */
    public function findWithExtras($id)
    {
        $query = $this->_em->createQuery('
            SELECT c, r, g, j
            FROM MaroonRPGBundle:Character c
            JOIN c.race r
            JOIN c.gender g
            JOIN c.job j
            WHERE c.id = :id
        ');
        $query->setParameter('id', $id);

        try {
            $character = $query->getSingleResult();
        } catch ( NoResultException $e ) {
            $character = null;
        }

        return $character;
    }

    /**
     * Creates a new character record in the database, called from the new character form.
     * Race, gender, and job are all pre-verified so we are go to take care of DB stuff.
     *
     * @param array $formData keys 'name', 'race', 'gender', 'job'
     * @param array $initialStats
     * @param \Maroon\RPGBundle\Entity\User $user
     * @return \Maroon\RPGBundle\Entity\Character
     */
    public function createNewCharacter(array $formData, array $initialStats, User $user)
    {
        $name = $formData['name'];
        $raceId = $formData['race'];
        $genderId = $formData['gender'];
        $jobId = $formData['job'];

        $em = $this->getEntityManager();

        $race   = $em->getRepository('MaroonRPGBundle:Race')->find($raceId);
        $gender = $em->getRepository('MaroonRPGBundle:Gender')->find($genderId);
        $job    = $em->getRepository('MaroonRPGBundle:Job')->find($jobId);

        $stats = new CharStats();
        foreach ( CharStats::$statAliases as $stat => $fullStat ) {
            if ( $stat == 'maxhp' || $stat == 'maxsp' ) {
                continue;
            }

            $value = $initialStats[$stat];
            if ( isset($race->getStatsInit()[$stat]) ) {
                $value += $race->getStatsInit()[$stat];
            }
            if ( isset($gender->getStatsInit()[$stat]) ) {
                $value += $gender->getStatsInit()[$stat];
            }
            if ( isset($job->getStatsInit()[$stat]) ) {
                $value += $job->getStatsInit()[$stat];
            }

            $stats->set($stat, $value);
        }

        $stats->set('maxhp', $stats->get('hp'));
        $stats->set('maxsp', $stats->get('sp'));

        $baseStats = clone $stats;

        $char = new Character();
        $char
            ->setName($name)
            ->setLevel(1)
            ->setExperience(0)
            ->setEquipment(new ArrayCollection())
            ->setBaseStats($baseStats)
            ->setStats($stats)
            ->setRace($race)
            ->setGender($gender)
            ->setJob($job);

        $user->addCharacter($char);

        $party = new Party();
        $party->addCharacter($char);
        $party->setUser($user);

        $em->persist($char);
        $em->persist($stats);
        $em->persist($baseStats);
        $em->persist($party);

        $em->flush();

        return $char;
    }
}