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

    public function validatedBy()
    {
        return 'modifier';
    }
}
