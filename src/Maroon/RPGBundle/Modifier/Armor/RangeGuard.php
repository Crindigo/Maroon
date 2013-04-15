<?php

namespace Maroon\RPGBundle\Modifier\Armor;

use Maroon\RPGBundle\Model\Action\AbstractAction;
use Maroon\RPGBundle\Modifier\AbstractModifier;
use Symfony\Component\DependencyInjection\ContainerInterface;

/*

Armor.RangeGuard:
    physical: true
    damageReduction: 50

 */


class RangeGuard extends AbstractModifier
{
    public function onReceiveAttack(AbstractAction $action)
    {
        // only respond to ranged aggro actions
        if ( !$action->hasFlag('ranged') || !$action->isAggro() ) {
            return true;
        }

        $category = $action->getCategory();

        if ( $category == AbstractAction::PHYSICAL && $this->config['physical'] ) {
            if ( $this->config['_physicalDamageReduction'] > 0 ) {
                $action->adjustGlobalHPChange(1 - ($this->config['_physicalDamageReduction'] / 100));
                $action->adjustGlobalSPChange(1 - ($this->config['_physicalDamageReduction'] / 100));
            }

            if ( $this->config['_physicalEvasionChance'] > 0 ) {
                $action->setHitChance($action->getHitChance() - $this->config['_physicalEvasionChance'] * 10);
            }
        } else if ( $category == AbstractAction::MAGICAL && $this->config['magical'] ) {
            if ( $this->config['_magicalDamageReduction'] > 0 ) {
                $action->adjustGlobalHPChange(1 - ($this->config['_magicalDamageReduction'] / 100));
                $action->adjustGlobalSPChange(1 - ($this->config['_magicalDamageReduction'] / 100));
            }

            if ( $this->config['_magicalEvasionChance'] > 0 ) {
                $action->setHitChance($action->getHitChance() - $this->config['_magicalEvasionChance'] * 10);
            }
        }

        return true;
    }

    public function getDescription()
    {
        return <<<'DESC'
Provides a way to reduce damage or increase evasion against ranged attacks.
Properties:
- magical (bool): true if this responds to magical attacks
- physical (bool): true if this responds to physical attacks
- damageReduction (number): reduce incoming damage by this percentage
- evasionChance (number): add chance to evade by this percentage
DESC;
    }

    public function mergeConfiguration(AbstractModifier $other)
    {
        $this->config['magical'] = ($this->config['magical'] || $other->config['magical']);
        $this->config['physical'] = ($this->config['physical'] || $other->config['physical']);

        $this->config['_physicalDamageReduction'] =
            $this->clampRange($this->config['_physicalDamageReduction'] + $other->config['_physicalDamageReduction'], 0, 100);
        $this->config['_physicalEvasionChance'] =
            $this->clampRange($this->config['_physicalEvasionChance'] + $other->config['_physicalEvasionChance'], 0, 100);

        $this->config['_magicalDamageReduction'] =
            $this->clampRange($this->config['_magicalDamageReduction'] + $other->config['_magicalDamageReduction'], 0, 100);
        $this->config['_magicalEvasionChance'] =
            $this->clampRange($this->config['_magicalEvasionChance'] + $other->config['_magicalEvasionChance'], 0, 100);
    }


    public function getConfigSpec()
    {
        $spec = parent::getConfigSpec();
        $spec['magical']  = ['boolean', 'default' => false];
        $spec['physical'] = ['boolean', 'default' => false];
        $spec['damageReduction'] = ['number', 'default' => 0, 'range' => '0:100'];
        $spec['evasionChance']   = ['number', 'default' => 0, 'range' => '0:100'];

        return $spec;
    }

    public function validateConfiguration(array $config, ContainerInterface $container)
    {
        $config = parent::validateConfiguration($config, $container);

        // internally separate damageReduction and evasionChance for physical/magical types
        // the old damageReduction/evasionChance configs will be for admins to see only, calculations
        // will all be done with the new ones.
        if ( $config['magical'] ) {
            $config['_magicalDamageReduction'] = $config['damageReduction'];
            $config['_magicalEvasionChance'] = $config['evasionChance'];
        }
        if ( $config['physical'] ) {
            $config['_physicalDamageReduction'] = $config['damageReduction'];
            $config['_physicalEvasionChance'] = $config['evasionChance'];
        }

        return $config;
    }


    /**
     * Returns an array of types this modifier applies to (item, mob, skill). List pending extension.
     *
     * @return array
     */
    public function getApplicableTypes()
    {
        return ['item'];
    }

    /**
     * Returns an array of events to subscribe to.
     * ['type' => ['event' => 'callbackMethod']]
     *
     * @return array
     */
    public function getEvents()
    {
        return [
            'item' => ['receiveAttack'],
        ];
    }

    /**
     * Returns the name of this modifier.
     *
     * @return string
     */
    public function getName()
    {
        return 'Armor.RangeGuard';
    }

}