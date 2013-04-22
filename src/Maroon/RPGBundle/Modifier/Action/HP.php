<?php

namespace Maroon\RPGBundle\Modifier\Action;

use Maroon\RPGBundle\Entity\CharStats;
use Maroon\RPGBundle\Model\Action\AbstractAction;
use Maroon\RPGBundle\Model\Item;
use Maroon\RPGBundle\Modifier\AbstractModifier;
use Maroon\RPGBundle\Modifier\ConfigurationException;
use Maroon\RPGBundle\Util\Calculator;
use Symfony\Component\DependencyInjection\ContainerInterface;

class HP extends AbstractModifier
{
    public function onAction(AbstractAction $action)
    {
        foreach ( $this->config as $elem => $formula ) {
            if ( $formula === ['0'] ) {
                continue; // optimization, don't bother if the formula is always 0
            }

            $elem = substr($elem, 1); // remove starting _

            $hp = $action->getChangeHP($elem);
            $calc = Calculator::fromCompiled($formula);
            $calc->value($this->getFormulaVars($action));

            $action->setChangeHP($elem, $hp + $calc->result());
        }

        return true;
    }

    public function onItemUse(Item $item, AbstractAction $action)
    {

    }

    private function getFormulaVars(AbstractAction $action)
    {
        $vars = [];

        $source = $action->getSource();
        $target = $action->getTarget();
        foreach ( CharStats::$statAliases as $stat => $full ) {
            $vars["source_$stat"] = $source->getStat($stat);
            $vars["target_$stat"] = $target->getStat($stat);
        }

        return $vars;
    }

    public function getDescription()
    {
        return <<<'DESC'
Sets HP change values by type. All HP and SP alterations in Maroon are associated with an element/type.
If you want a "generic physical" or "non-elemental magic" type, use the physical and magic keys respectively.
Types: physical, blunt, slash, pierce, magic, fire, ice, water, electric, earth, wind, holy, shadow, gravity
You can add a - to the end of the type to make it subtract HP. So to add 50 fire damage:

Action.HP:
&nbsp;&nbsp;fire-: 50

Formulas can also be used, like to make HP damage equal to the source's intelligence times 2:

Action.HP:
&nbsp;&nbsp;fire-: 'source_int * 2'

Formula variables:
- source_stat (stat = hp, maxhp, sp, maxsp, str, dex, int, def, mdef, eva, meva, spd, luck)
- target_stat
- weapon_damage (contains the base damage dealt by the weapon, only useful if modifier is used on a weapon)
DESC;
    }

    public function getConfigSpec(ContainerInterface $container)
    {
        $spec = parent::getConfigSpec($container);

        $physicalTypes = $container->getParameter('maroon_rpg.attack_types.physical');
        $magicalTypes  = $container->getParameter('maroon_rpg.attack_types.magical');

        foreach ( array_merge($physicalTypes, $magicalTypes) as $elem ) {
            // string is fine, since everything will be a formula.
            // number 4 becomes string "4" which as a formula just evaluates to 4
            $spec[$elem] = ['string', 'default' => '0'];
            $spec["$elem-"] = ['string', 'default' => '0'];
        }

        return $spec;
    }

    public function mergeConfiguration(AbstractModifier $other)
    {
        // elem will really be like _fire, _slash, etc.
        foreach ( $other->config as $elem => $otherFormula ) {
            $this->config[$elem] = Calculator::merge($this->config[$elem], $otherFormula, '+');
        }
    }

    public function validateConfiguration(array $config, ContainerInterface $container)
    {
        $config = parent::validateConfiguration($config, $container);

        // interally store as RPN formulas, merge by doing [f, g, +]
        $physicalTypes = $container->getParameter('maroon_rpg.attack_types.physical');
        $magicalTypes  = $container->getParameter('maroon_rpg.attack_types.magical');

        foreach ( array_merge($physicalTypes, $magicalTypes) as $elem ) {
            // if 'type' and 'type-' keys both exist, error
            if ( $config[$elem] !== '0' && $config["$elem-"] !== '0' ) {
                throw new ConfigurationException($elem, "Both '$elem' and '$elem-' keys cannot co-exist.");
            }

            if ( $config["$elem-"] !== '0' ) {
                $comp = Calculator::fromExpr($config["$elem-"])->compile();
                $config["_$elem"] = Calculator::negate($comp);
            } else {
                $config["_$elem"] = Calculator::fromExpr($config[$elem])->compile();
            }

            unset($config[$elem], $config["$elem-"]);
        }

        return $config;
    }

    public function getApplicableTypes()
    {
        return ['item', 'skill'];
    }

    public function getEvents()
    {
        return ['action', 'itemUse'];
    }

    public function getName()
    {
        return 'Action.HP';
    }
}