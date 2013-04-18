<?php

namespace Maroon\RPGBundle\Modifier\Core;

use Maroon\RPGBundle\Entity\CharStats;
use Maroon\RPGBundle\Model\Character;
use Maroon\RPGBundle\Model\Item;
use Maroon\RPGBundle\Modifier\AbstractModifier;
use Symfony\Component\DependencyInjection\ContainerInterface;

// $item->runModifiers('equip', $character)
// $item->runModifiers('unequip', $character)
// $item->runModifiers('rebuildStats', $character)

/**
 * Modifies statistics of an item.
 *
 * Std.Statistics:
 *   str: 10
 *   def: 5
 *
 * etc.
 *
 * @package Maroon\RPGBundle\Modifier
 */
class Statistics extends AbstractModifier
{
    public function onEquip(Item $item, $character)
    {

    }

    public function onUnequip(Item $item, $character)
    {

    }

    public function onRebuildStats(Character $character)
    {
        // when stats are being rebuilt, the character's stats are reset to base and then built again
        // so we can adjust the stats here in the event.

        foreach ( $this->config as $stat => $value ) {
            if ( strpos($stat, 'pct_') === 0 ) {
                $stat = substr($stat, 4);
                $value = $character->getBaseStat($stat) * $value / 100;
            }
            $character->adjustStat($stat, $value);
        }
    }

    public function getName()
    {
        return 'Core.Statistics';
    }

    public function getApplicableTypes()
    {
        return ['item'];
    }

    public function getEvents()
    {
        return ['equip', 'unequip', 'rebuildStats'];
    }

    public function getDescription()
    {
        return <<<'DESC'
Modifies statistics for equippable items and maybe mobs.
Properties:
- maxhp, maxmp, str, dex, int, def, mdef, eva, meva, spd, luck (int): raises stat by number
- the above, with _pct appended, so maxhp_pct, etc. (number): raises stat by percentage
DESC;
    }

    public function getConfigSpec(ContainerInterface $container)
    {
        $spec = parent::getConfigSpec($container);
        foreach ( CharStats::$statAliases as $stat => $full ) {
            $spec[$stat] = ['integer', 'default' => 0, 'range' => '-1000:1000'];
            $spec['pct_' . $stat] = ['integer', 'default' => 0, 'range' => '-100:100']; // percentages, maybe
        }
        return $spec;
    }

    public function getConfigExamples()
    {
        return [
            [
                'maxhp' => 20,
                'maxsp' => 10,
                'str'  => 5,
                'dex'  => 5,
                'int'  => 5,
                'def' => 5,
                'mdef'  => 5,
                'eva'  => 5,
                'meva' => 5,
                'spd'  => 5,
                'luck' => 5,
            ],
        ];
    }

    public function mergeConfiguration(AbstractModifier $other)
    {
        foreach ( $other->config as $stat => $value ) {
            $this->config[$stat] += $value;
        }
    }

    /**
     * @param array $config
     * @param ContainerInterface $container
     * @return array
     */
    public function validateConfiguration(array $config, ContainerInterface $container)
    {
        // possibly mess with validating statistics based on $container->getParameter('maroon_rpg.base_stats') keys?

        // convert 'hp' and 'sp' keys to 'maxhp' and 'maxsp'
        if ( isset($config['hp']) ) {
            $config['maxhp'] = $config['hp'];
            unset($config['hp']);
        }
        if ( isset($config['sp']) ) {
            $config['maxsp'] = $config['sp'];
            unset($config['sp']);
        }

        if ( isset($config['pct_hp']) ) {
            $config['pct_maxhp'] = $config['pct_hp'];
            unset($config['pct_hp']);
        }
        if ( isset($config['pct_sp']) ) {
            $config['pct_maxsp'] = $config['pct_sp'];
            unset($config['pct_sp']);
        }

        return parent::validateConfiguration($config, $container);
    }
}