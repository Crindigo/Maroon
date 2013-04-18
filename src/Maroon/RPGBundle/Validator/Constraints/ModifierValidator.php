<?php

namespace Maroon\RPGBundle\Validator\Constraints;

use Maroon\RPGBundle\Modifier\AbstractModifier;
use Maroon\RPGBundle\Modifier\ConfigurationException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;

class ModifierValidator extends ConstraintValidator
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    public function validate($value, Constraint $constraint)
    {
        foreach ( $value['orig'] as $modifierName => $config ) {
            $modifierClassName = '\Maroon\RPGBundle\Modifier\\' . str_replace('.', '\\', $modifierName);
            // check if this modifier does not exist, or if it has no period (modifiers are only in subfolders)
            if ( !class_exists($modifierClassName) || strpos($modifierName, '.') === false ) {
                $this->context->addViolation($constraint->message, array('%errors%' => "Modifier '$modifierName' does not exist"));
                continue;
            }

            /** @var $modifier AbstractModifier */
            $modifier = new $modifierClassName();
            try {
                $modifier->validateConfiguration($config, $this->container);
            } catch ( ConfigurationException $e ) {
                $this->context->addViolation($constraint->message, [
                    '%errors%' => "$modifierName [{$e->key}] -- " . $e->getMessage(),
                ]);
            }
        }
    }
}
