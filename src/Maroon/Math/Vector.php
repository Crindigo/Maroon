<?php

namespace Maroon\Math;

/**
 * Immutable n-dimensional vector. This and other things in Maroon\Math may be useful should I
 * decide to implement some kind of procedural worldgen or advanced battling code.
 *
 * @package Maroon\Math
 */
class Vector
{
    private $dimensions;

    private $values = [];

    private $magnitude = null;

    public function __construct()
    {
        $values = func_get_args();
        if ( count($values) == 1 && is_array($values[0]) ) {
            $values = $values[0];
        }

        foreach ( $values as $val ) {
            if ( !is_numeric($val) ) {
                throw new \InvalidArgumentException('Vector values must be numeric');
            }
        }
        $this->dimensions = count($values);
        $this->values = $values;
    }

    public function getDimensions()
    {
        return $this->dimensions;
    }

    public function get($i)
    {
        return $this->values[$i];
    }

    public function getX() {
        return $this->get(0);
    }
    public function getY() {
        return $this->get(1);
    }
    public function getZ() {
        return $this->get(2);
    }
    public function getW() {
        return $this->get(3);
    }

    public function __get($key)
    {
        switch ( $key ) {
            case 'x': return $this->getX();
            case 'y': return $this->getY();
            case 'z': return $this->getZ();
            case 'w': return $this->getW();

            case 'xy': return new Vector($this->getX(), $this->getY());
            case 'yz': return new Vector($this->getY(), $this->getZ());
            case 'xyz': return new Vector($this->getX(), $this->getY(), $this->getZ());
        }

        throw new \RuntimeException('Property "' . $key . '" does not exist.');
    }

    public function getMagnitude()
    {
        if ( $this->magnitude !== null ) {
            return $this->magnitude;
        }

        /*
        $sum = 0;
        for ( $i = 0; $i < $this->dimensions; $i++ ) {
            $sum += pow($this->values[$i], 2);
        }

        return $this->magnitude = sqrt($sum);
        */
        return $this->magnitude = $this->pnorm(2);
    }

    public function pnorm($p)
    {
        $sum = 0;
        for ( $i = 0; $i < $this->dimensions; $i++ ) {
            $sum = pow(abs($this->values[$i]), $p);
        }

        return pow($sum, 1 / $p);
    }

    public function chebyshevNorm()
    {
        $max = 0;
        for ( $i = 0; $i < $this->dimensions; $i++ ) {
            $val = abs($this->values[$i]);
            if ( $val > $max ) {
                $max = $val;
            }
        }

        return $max;
    }

    public function normalize()
    {
        $values = array();
        $magnitude = $this->getMagnitude();
        for ( $i = 0; $i < $this->dimensions; $i++ ) {
            $values[] = $this->values[$i] / $magnitude;
        }

        return new Vector($values);
    }

    public function angleTo(Vector $vector)
    {
        return acos($this->dot($vector) / ($this->getMagnitude() * $vector->getMagnitude()));
    }

    public function add(Vector $vector)
    {
        if ( $vector->dimensions != $this->dimensions ) {
            throw new \InvalidArgumentException('Passed vector requires ' . $this->dimensions
                . ' dimensions, but ' . $vector->dimensions . ' was given.');
        }

        $values = [];
        for ( $i = 0; $i < $this->dimensions; $i++ ) {
            $values[] = $this->values[$i] + $vector->values[$i];
        }

        return new Vector($values);
    }

    public function subtract(Vector $vector)
    {
        return $this->add($vector->multiply(-1));
    }

    public function multiply($scalar)
    {
        $values = [];
        for ( $i = 0; $i < $this->dimensions; $i++ ) {
            $values[] = $this->values[$i] * $scalar;
        }
        return new Vector($values);
    }

    public function dot(Vector $vector)
    {
        if ( $vector->dimensions != $this->dimensions ) {
            throw new \InvalidArgumentException('Passed vector requires ' . $this->dimensions
                . ' dimensions, but ' . $vector->dimensions . ' was given.');
        }

        $product = 0;
        for ( $i = 0; $i < $this->dimensions; $i++ ) {
            $product += $this->values[$i] * $vector->values[$i];
        }

        return $product;
    }

    public function cross(Vector $vector)
    {
        if ( $this->dimensions !== 3 || $vector->dimensions !== 3 ) {
            throw new \RuntimeException('Cross multiplication can only be done between two 3D vectors.');
        }

        return new Vector(
            $this->getY() * $vector->getZ() - $this->getZ() * $vector->getY(),
            $this->getZ() * $vector->getX() - $this->getX() * $vector->getZ(),
            $this->getX() * $vector->getY() - $this->getY() * $vector->getX()
        );
    }
}