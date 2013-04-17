<?php

namespace Maroon\RPGBundle\Form;

use Maroon\RPGBundle\Modifier\AbstractModifier;
use Maroon\RPGBundle\Modifier\ConfigurationException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\DataTransformerInterface;
use Symfony\Component\Form\Exception\TransformationFailedException;
use Symfony\Component\Form\Exception\UnexpectedTypeException;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class ModifierTransformer implements DataTransformerInterface
{
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Transforms a value from the original representation to a transformed representation.
     *
     * This method is called on two occasions inside a form field:
     *
     * 1. When the form field is initialized with the data attached from the datasource (object or array).
     * 2. When data from a request is bound using {@link Form::bind()} to transform the new input data
     *    back into the renderable format. For example if you have a date field and bind '2009-10-10' onto
     *    it you might accept this value because its easily parsed, but the transformer still writes back
     *    "2009/10/10" onto the form field (for further displaying or other purposes).
     *
     * This method must be able to deal with empty values. Usually this will
     * be NULL, but depending on your implementation other empty values are
     * possible as well (such as empty strings). The reasoning behind this is
     * that value transformers must be chainable. If the transform() method
     * of the first value transformer outputs NULL, the second value transformer
     * must be able to process that value.
     *
     * By convention, transform() should return an empty string if NULL is
     * passed.
     *
     * @param mixed $value The value in the original representation
     *
     * @return mixed The value in the transformed representation
     *
     * @throws UnexpectedTypeException   when the argument is not a string
     * @throws TransformationFailedException  when the transformation fails
     */
    public function transform($value)
    {
        // transforms the structure of modifiers back into Yaml representation
        if ( !isset($value['orig']) || empty($value['orig']) ) {
            return '';
        }

        // add an extra newline between top-level objects
        $yaml = Yaml::dump($value['orig'], 2, 2);
        return preg_replace('/(\r?\n)([A-Z])/', "$1$1$2", $yaml);
    }

    /**
     * Transforms a value from the transformed representation to its original
     * representation.
     *
     * This method is called when {@link Form::bind()} is called to transform the requests tainted data
     * into an acceptable format for your data processing/model layer.
     *
     * This method must be able to deal with empty values. Usually this will
     * be an empty string, but depending on your implementation other empty
     * values are possible as well (such as empty strings). The reasoning behind
     * this is that value transformers must be chainable. If the
     * reverseTransform() method of the first value transformer outputs an
     * empty string, the second value transformer must be able to process that
     * value.
     *
     * By convention, reverseTransform() should return NULL if an empty string
     * is passed.
     *
     * @param mixed $value The value in the transformed representation
     *
     * @return mixed The value in the original representation
     *
     * @throws UnexpectedTypeException   when the argument is not of the expected type
     * @throws TransformationFailedException  when the transformation fails
     */
    public function reverseTransform($value)
    {
        // transforms a text blob containing Yaml into a structure of modifiers
        $value = trim($value);
        if ( empty($value) ) {
            return ['orig' => [], 'modifiers' => []];
        }

        try {
            $yaml = Yaml::parse($value);
        } catch ( ParseException $e ) {
            throw new TransformationFailedException('Could not parse Yaml: ' . $e->getMessage());
        }

        // $yaml = ['Modifier.Name' => ['key' => 'val', 'k2' => 'val2']]
        $mods = ['orig' => $yaml, 'modifiers' => []];

        foreach ( $yaml as $modifierName => $config ) {
            $modifierClassName = '\Maroon\RPGBundle\Modifier\\' . str_replace('.', '\\', $modifierName);
            if ( !class_exists($modifierClassName) ) {
                continue;
            }

            /** @var $modifier AbstractModifier */
            $modifier = new $modifierClassName();
            if ( is_subclass_of($modifier, '\Maroon\RPGBundle\Modifier\AbstractModifier') ) {
                try {
                    $mods['modifiers'][$modifierClassName] = $modifier->validateConfiguration($config, $this->container);
                } catch ( ConfigurationException $e ) {
                    // ignore them here, we'll report it in the validator
                    continue;
                }
            }
        }

        return $mods;
    }

}