<?php

namespace Maroon\RPGBundle\Validator\Constraints;

use Maroon\Modifier\AbstractModifier;
use Maroon\Modifier\ConfigurationException;
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
            // !strpos is appropriate, we want to reject . as the first character
            if ( !strpos($modifierName, '.') ) {
                $this->context->addViolation($constraint->message,
                    ['%errors%' => "Modifier '$modifierName' does not exist"]);
                continue;
            }

            $modifierClassName = '\Maroon\RPGBundle\Modifier\\' . str_replace('.', '\\', $modifierName);
            // check if this modifier does not exist
            if ( !class_exists($modifierClassName) ) {
                $this->context->addViolation($constraint->message,
                    ['%errors%' => "Modifier '$modifierName' does not exist"]);
                continue;
            }

            /** @var $modifier AbstractModifier */
            $modifier = new $modifierClassName();
            if ( !in_array($constraint->modifierType, $modifier->getApplicableTypes()) ) {
                $this->context->addViolation($constraint->message, [
                    '%errors%' => "$modifierName cannot be applied to {$constraint->modifierType} types",
                ]);
            }
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
