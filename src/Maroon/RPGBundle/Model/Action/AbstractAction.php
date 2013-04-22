<?php
/**
 * Created by IntelliJ IDEA.
 * User: steven
 * Date: 4/14/13
 * Time: 3:53 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Maroon\RPGBundle\Model\Action;

use Maroon\RPGBundle\Model\Character;

/**
 * Top-level class for all actions taken in battle. Weapon attacks, skills, item usage, etc.
 *
 * @package Maroon\RPGBundle\Model\Action
 */
abstract class AbstractAction
{
    const PHYSICAL = 'physical';
    const MAGICAL = 'magical';

    /**
     * Character who initiated the action.
     *
     * @var Character
     */
    private $source;

    /**
     * Character that is the target of the action.
     *
     * @var Character
     */
    private $target;

    /**
     * Action category, physical or magical.
     *
     * @var string
     */
    private $category = self::PHYSICAL;

    /**
     * Whether the action is aggro or not. Anything with negative effects will generally be aggro.
     * Healing skills & items will generally NOT be aggro.
     *
     * @var bool
     */
    private $aggro = true;

    /**
     * Set of boolean flags for the action. ignoreArmor, ranged, etc.
     *
     * @var array
     */
    private $flags = array();

    /**
     * Amount to change the target's HP. Negative is damage, positive is healing.
     * Stored as a map of element name to HP values.
     *
     * @var array
     */
    private $changeHP = array();

    /**
     * Amount to change the target's SP. Negative is damage, positive is healing.
     * Stored as a map of element name to SP values.
     *
     * @var array
     */
    private $changeSP = array();

    /**
     * Base chance for the action to hit. 1000 = 100%.
     *
     * @var int
     */
    private $hitChance = 1000;

    /**
     * Returns the type of the action (weapon, item, skill, etc.)
     *
     * @return string
     */
    abstract public function getType();

    /**
     * @param Character $source
     * @return AbstractAction
     */
    public function setSource(Character $source)
    {
        $this->source = $source;
        return $this;
    }

    /**
     * Returns the character who initiated this action.
     *
     * @return Character
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * @param Character $target
     * @return AbstractAction
     */
    public function setTarget(Character $target)
    {
        $this->target = $target;
        return $this;
    }

    /**
     * @return Character
     */
    public function getTarget()
    {
        return $this->target;
    }

    /**
     * @param $category
     * @return AbstractAction
     * @throws \InvalidArgumentException
     */
    public function setCategory($category)
    {
        if ( $category != self::PHYSICAL && $category != self::MAGICAL ) {
            throw new \InvalidArgumentException('Category must be physical or magical');
        }

        $this->category = $category;
        return $this;
    }

    /**
     * Returns physical or magical.
     *
     * @return string
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param bool $aggro
     * @return $this
     */
    public function setAggro($aggro)
    {
        $this->aggro = $aggro;
        return $this;
    }

    /**
     * @return bool
     */
    public function isAggro()
    {
        return $this->aggro;
    }

    public function setHitChance($hit)
    {
        $this->hitChance = $hit;
        return $this;
    }

    public function getHitChance()
    {
        return $this->hitChance;
    }

    // --------------------------------
    // HP/SP adjustment
    // Elements are all separated, final damage is the sum of all parts after all modifiers/defenses are applied.
    //

    public function setChangeHP($element, $hp) {
        $this->changeHP[$element] = (int) $hp;
        return $this;
    }

    public function setChangeSP($element, $sp) {
        $this->changeSP[$element] = (int) $sp;
        return $this;
    }

    public function setHPDamage($element, $hp) {
        $this->changeHP[$element] = -1 * (int) $hp;
        return $this;
    }

    public function setSPDamage($element, $sp) {
        $this->changeSP[$element] = -1 * (int) $sp;
        return $this;
    }

    public function setHPHeal($element, $hp) {
        return $this->setChangeHP($element, $hp);
    }

    public function setSPHeal($element, $sp) {
        return $this->setChangeSP($element, $sp);
    }

    public function getChangeHP($element) {
        return isset($this->changeHP[$element]) ? $this->changeHP[$element] : 0;
    }

    public function getChangeSP($element) {
        return isset($this->changeSP[$element]) ? $this->changeSP[$element] : 0;
    }

    public function getHPDamage($element) {
        return -1 * $this->getChangeHP($element);
    }

    public function getSPDamage($element) {
        return -1 * $this->getChangeSP($element);
    }

    public function getHPHeal($element) {
        return $this->getChangeHP($element);
    }

    public function getSPHeal($element) {
        return $this->getChangeSP($element);
    }

    /**
     * Globally adjust all HP change elements by a percentage.
     *
     * @param $percentage 1.0 = no adjustment, 0.5 = half, 1.5 = 50% more, etc.
     */
    public function adjustGlobalHPChange($percentage)
    {
        foreach ( $this->changeHP as $element => $val ) {
            $this->changeHP[$element] = $val * $percentage;
        }
    }

    /**
     * Globally adjust all SP change elements by a percentage.
     *
     * @param $percentage 1.0 = no adjustment, 0.5 = half, 1.5 = 50% more, etc.
     */
    public function adjustGlobalSPChange($percentage)
    {
        foreach ( $this->changeSP as $element => $val ) {
            $this->changeSP[$element] = $val * $percentage;
        }
    }

    // --------------------------------
    // Flags
    //

    /**
     * @param string $flag
     * @return bool
     */
    public function hasFlag($flag)
    {
        return isset($this->flags[$flag]) && $this->flags[$flag];
    }

    public function setFlag($flag)
    {
        $this->flags[$flag] = true;
        return $this;
    }

    public function unsetFlag($flag)
    {
        if ( $this->hasFlag($flag) ) {
            unset($this->flags[$flag]);
        }
        return $this;
    }

    public function toggleFlag($flag)
    {
        if ( $this->hasFlag($flag) ) {
            unset($this->flags[$flag]);
        } else {
            $this->setFlag($flag);
        }
        return $this;
    }
}