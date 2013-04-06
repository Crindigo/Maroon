<?php

namespace Maroon\RPGBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Maroon\RPGBundle\Entity\CharStats;
use Maroon\RPGBundle\Entity\Character;
use Maroon\RPGBundle\Entity\User;

class CharacterRepository extends EntityRepository
{
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
            ->setEquipment(null)
            ->setBaseStats($baseStats)
            ->setStats($stats)
            ->setRace($race)
            ->setGender($gender)
            ->setPrimaryJob($job);
            //->setSecondaryJob(null);

        $user->addCharacter($char);

        $em->persist($char);
        $em->persist($stats);
        $em->persist($baseStats);

        $em->flush();

        return $char;
    }
}