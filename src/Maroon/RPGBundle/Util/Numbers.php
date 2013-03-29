<?php

namespace Maroon\RPGBundle\Util;

/**
 * Number-related utility functions.
 */
class Numbers
{
    const YELLOW_PERCENT = .3;
    const RED_PERCENT = .1;

    const GREEN_CLASS = 'danger-green';
    const YELLOW_CLASS = 'danger-yellow';
    const RED_CLASS = 'danger-red';

    /**
     * Returns the CSS class for a number depending on how low or high it is related to its maximum.
     *
     * @static
     * @param $value
     * @param $maxValue
     * @param bool $reverse If true, higher is worse.
     * @return string
     */
    public static function getDangerClass($value, $maxValue, $reverse = false)
    {
        if ( $maxValue <= 0 ) {
            return self::RED_CLASS;
        }

        $percent = $value / $maxValue;
        if ( $reverse ) {
            $percent = 1 - $percent;
        }
        $percent = self::clamp($percent, 0, 1);

        if ( $percent <= self::RED_PERCENT ) {
            return self::RED_CLASS;
        } else if ( $percent <= self::YELLOW_PERCENT ) {
            return self::YELLOW_CLASS;
        }

        return self::GREEN_CLASS;
    }

    /**
     * Clamps a value so it is between $min and $max, inclusive.
     *
     * @static
     * @param $value
     * @param $min
     * @param $max
     * @return mixed
     */
    public static function clamp($value, $min, $max)
    {
        //assert($min <= $max);
        return min($max, max($value, $min));
    }

    /**
     * Randomizes a value so it fluctuates by an up/down percentage. For example, randomize(50, .1) will
     * return a random value between 45 and 55.
     *
     * @static
     * @param $value
     * @param $amount
     * @return int
     */
    public static function randomize($value, $amount)
    {
        if ( $amount < 0 ) {
            $amount = 0;
        }

        // ex: (50, .10) => random between 45, 55
        $delta = round($value * $amount);
        return mt_rand($value - $delta, $value + $delta);
    }

    /**
     * Rolls $dice number of $sides-sided die, and returns the sum.
     *
     * @static
     * @param $sides
     * @param int $dice
     * @return int
     */
    public static function diceRoll($sides, $dice = 1)
    {
        $sum = 0;
        for ( $i = 0; $i < $dice; $i++ ) {
            $sum += mt_rand(1, $sides);
        }
        return $sum;
    }
}
