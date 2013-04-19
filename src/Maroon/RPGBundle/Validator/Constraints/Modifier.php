<?php

namespace Maroon\RPGBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 *
 * @package Maroon\RPGBundle\Validator\Constraints
 */
class Modifier extends Constraint
{
    public $message = 'The modifier configuration has a problem: %errors%';
    public $modifierType;

    public function __construct(array $type)
    {
        $this->modifierType = $type['value'];
    }

    public function validatedBy()
    {
        return 'modifier';
    }
}
