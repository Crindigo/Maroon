<?php

namespace Maroon\RPGBundle\Modifier;

use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Top-level abstract class for the modifier system. Defines simple methods to get a name and description.
 *
 * @package Maroon\RPGBundle\Modifier
 */
abstract class AbstractModifier
{
    /**
     * Contains info parsed from the modifier configuration.
     *
     * @var array
     */
    protected $config = array();

    /**
     * Returns an array of types this modifier applies to (item, mob, skill). List pending extension.
     *
     * @return array
     */
    abstract public function getApplicableTypes();

    /**
     * Returns an array of events to subscribe to.
     * ['type' => ['event' => 'callbackMethod']]
     *
     * @return array
     */
    abstract public function getEvents();

    /**
     * Returns the name of this modifier.
     *
     * @return string
     */
    abstract public function getName();

    /**
     * Returns the description of this modifier.
     *
     * @return string
     */
    public function getDescription()
    {
        return 'Somebody was lazy and did not override getDescription() in ' . get_class($this);
    }

    /**
     * Sets the configuration parameters loaded from the DB.
     *
     * @param array $config
     * @return $this
     */
    public function setConfig(array $config)
    {
        $this->config = $config;
        return $this;
    }

    /**
     * Returns the configuration data for the modifier.
     *
     * @return array
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * Returns the configuration specification for this modifier. Returns an array like:
     * [
     *   'key'    => ['type', 'default' => '']
     *   'numkey' => ['number', 'default' => 2, 'range' => '1-3']
     * ]
     * @param ContainerInterface $container
     * @return array
     */
    public function getConfigSpec(ContainerInterface $container)
    {
        return array();
    }

    /**
     * Returns sample configurations which will be dumped to Yaml in order to help administrators.
     *
     * @return array
     */
    public function getConfigExamples()
    {
        return array();
    }

    /**
     * If the same modifier is defined later on, this defines the behavior on how to merge the two together.
     * By default array_merges the other configuration into this one.
     *
     * This can happen for something like affixes (blah of strength, when the base item already has +str).
     * The situation arises if you have a base item, and a user/character has an inventory/equipment
     * record that "extends" the base item with extra data, including extra modifiers.
     *
     * @param AbstractModifier $other
     */
    public function mergeConfiguration(AbstractModifier $other)
    {
        $this->config = array_merge($this->config, $other->config);
    }

    /**
     * Validates and coerces the passed configuration array to fit within data types.
     * If something can't be coerced (missing and no default, non-numeric but set to numeric, etc.),
     * throws a ConfigurationException.
     *
     * @param array $config
     * @param ContainerInterface $container
     * @throws ConfigurationException
     * @return array Coerced config
     */
    public function validateConfiguration(array $config, ContainerInterface $container)
    {
        $spec = $this->getConfigSpec($container);

        foreach ( $spec as $key => $params ) {
            if ( !is_array($params) ) {
                $params = array($params);
            }

            // check for required param missing
            if ( !isset($config[$key]) ) {
                if ( !isset($params['default']) ) {
                    throw new ConfigurationException($key, 'Required key missing');
                } else {
                    $config[$key] = $params['default'];
                    continue;
                }
            }

            // check data type
            $type = $params[0];
            if ( $type == 'object' ) {
                continue; // would need a custom validator for this
            } else if ( $type == 'string' ) {
                $config[$key] = trim((string) $config[$key]);
            } else if ( $type == 'number' || $type == 'integer' ) {
                if ( !is_numeric($config[$key]) ) {
                    throw new ConfigurationException($key, 'Key must be numeric');
                }
                if ( $type == 'integer' ) {
                    $config[$key] = intval($config[$key]);
                } else {
                    $config[$key] = floatval($config[$key]);
                }

                if ( isset($params['range']) ) {
                    list($min, $max) = explode(':', $params['range']);
                    if ( $min === '' ) {
                        $min = -PHP_INT_MAX;
                    }
                    if ( $max === '' ) {
                        $max = PHP_INT_MAX;
                    }
                    $min = $type == 'integer' ? intval($min) : floatval($min);
                    $max = $type == 'integer' ? intval($max) : floatval($max);
                    if ( $min > $max ) {
                        throw new ConfigurationException($key, 'Range max is lower than min');
                    }
                    $config[$key] = $this->clampRange($config[$key], $min, $max);
                }
            } else if ( $type == 'boolean' ) {
                if ( $config[$key] == 'true' ) {
                    $config[$key] = true;
                } else if ( $config[$key] == 'false' ) {
                    $config[$key] = false;
                }
                $config[$key] = (bool) $config[$key];
            } else {
                throw new ConfigurationException($key, 'Invalid parameter type: ' . $type);
            }
        }

        // strip out config keys that are not in $spec
        return array_intersect_key($config, $spec);
    }

    protected function clampRange($num, $min, $max = null)
    {
        if ( is_string($min) && $max === null ) {
            list($min, $max) = explode(':', $min);
        }
        return min($max, max($min, $num));
    }
}
