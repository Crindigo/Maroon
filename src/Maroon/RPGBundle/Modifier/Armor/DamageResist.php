<?php

namespace Maroon\RPGBundle\Modifier\Armor;

use Maroon\RPGBundle\Model\Action\AbstractAction;
use Maroon\RPGBundle\Modifier\AbstractModifier;
use Symfony\Component\DependencyInjection\ContainerInterface;

class DamageResist extends AbstractModifier
{
    private static $range = '-1000:200';

    public function onReceiveAttack(AbstractAction $action)
    {
        if ( !$action->isAggro() ) {
            return true;
        }

        foreach ( $this->config as $elem => $resistance ) {
            if ( $resistance == 0 ) {
                continue; // no changes made
            }

            $hp = $action->getChangeHP($elem);
            if ( $hp != 0 ) {
                $action->setChangeHP($elem, $hp - ($hp * $resistance / 100));
            }

            $sp = $action->getChangeSP($elem);
            if ( $sp != 0 ) {
                $action->setChangeSP($elem, $sp - ($sp * $resistance / 100));
            }
        }

        return true;
    }

    /**
     * Returns an array of types this modifier applies to (item, mob, skill). List pending extension.
     *
     * @return array
     */
    public function getApplicableTypes()
    {
        return ['item', 'race', 'job'];
    }

    /**
     * Returns an array of events to subscribe to.
     * ['type' => ['event' => 'callbackMethod']]
     *
     * @return array
     */
    public function getEvents()
    {
        return ['receiveAttack'];
    }

    /**
     * Returns the name of this modifier.
     *
     * @return string
     */
    public function getName()
    {
        return 'Armor.DamageResist';
    }

    public function getDescription()
    {
        return <<<'DESC'
Reduces damage of specific types by given percentages. Negative numbers increase damage.
Numbers above 100 will absorb the damage type by (number - 100) percent.
Properties:
- all (number): reduces damage from all damage types
- allPhysical (number): reduces damage from physical types (physical, blunt, slash, pierce)
- allMagical (number): reduces damage from magical types (magic, fire, ice, water, electric, earth, wind, holy, shadow, gravity)
- you can also specify individual types listed in the last two
DESC;
    }

    public function getConfigSpec(ContainerInterface $container)
    {
        $spec = parent::getConfigSpec($container);

        $physicalTypes = $container->getParameter('maroon_rpg.attack_types.physical');
        $magicalTypes  = $container->getParameter('maroon_rpg.attack_types.magical');

        $spec['all'] = ['number', 'default' => 0, 'range' => self::$range];
        $spec['allMagical'] = ['number', 'default' => 0, 'range' => self::$range];
        $spec['allPhysical'] = ['number', 'default' => 0, 'range' => self::$range];

        foreach ( array_merge($physicalTypes, $magicalTypes) as $elem ) {
            $spec[$elem] = ['number', 'default' => 0, 'range' => self::$range];
        }

        return $spec;
    }

    public function mergeConfiguration(AbstractModifier $other)
    {
        foreach ( $other->config as $elem => $value ) {
            $this->config[$elem] = $this->clampRange($this->config[$elem] + $other->config[$elem], self::$range);
        }
    }

    public function validateConfiguration(array $config, ContainerInterface $container)
    {
        $config = parent::validateConfiguration($config, $container);

        // the final result will have all, allMagical, allPhysical removed
        // so just add their numbers into related elements.

        $physicalTypes = $container->getParameter('maroon_rpg.attack_types.physical');
        $magicalTypes  = $container->getParameter('maroon_rpg.attack_types.magical');
        $allTypes      = array_merge($physicalTypes, $magicalTypes);

        foreach ( $allTypes as $type ) {
            $config[$type] += $config['all'];
            if ( in_array($type, $physicalTypes) ) {
                $config[$type] += $config['allPhysical'];
            }
            if ( in_array($type, $magicalTypes) ) {
                $config[$type] += $config['allMagical'];
            }
        }

        unset($config['all'], $config['allPhysical'], $config['allMagical']);

        return $config;
    }
}