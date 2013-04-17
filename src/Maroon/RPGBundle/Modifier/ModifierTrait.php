<?php

namespace Maroon\RPGBundle\Modifier;

trait ModifierTrait
{
    /**
     * @var AbstractModifier[]
     */
    protected $modifiers = array();

    public function getModifiers()
    {
        return $this->modifiers;
    }

    public function setModifiers($modifiers)
    {
        $this->modifiers = $modifiers;
        return $this;
    }

    /**
     * Executes the modifiers on this object that listen to $event. Additional arguments
     * are passed to the modifiers' callback methods.
     *
     * @param $event
     */
    public function runModifiers($event)
    {
        $args = func_get_args();
        array_shift($args);

        //$type = $this->getModifierType();

        foreach ( $this->modifiers as $modifier ) {
            $evts = $modifier->getEvents();
            if ( in_array($event, $evts) ) {
                $method = 'on' . ucfirst($event);
                $ret = call_user_func_array(array($modifier, $method), $args);
                if ( $ret === false ) {
                    break;
                }
            }
        }
    }

    abstract public function getModifierType();
}
