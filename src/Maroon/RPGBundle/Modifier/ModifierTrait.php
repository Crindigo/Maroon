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

    public function runModifiers($event)
    {
        $args = func_get_args();
        array_shift($args);

        $type = $this->getModifierType();

        foreach ( $this->modifiers as $modifier ) {
            $evts = $modifier->getEvents();
            if ( isset($evts[$type]) && in_array($event, $evts[$type]) ) {
                $method = 'on' . ucfirst($event);
            }
        }
    }

    abstract public function getModifierType();
}
