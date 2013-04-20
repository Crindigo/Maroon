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

    public static function getStatBonus($coefficient, $newLevel, $float = false)
    {
        if ( $coefficient == 0 ) {
            return 0;
        }

        $bonus = $coefficient * log($coefficient * ($newLevel - 1));
        if ( $float ) {
            return $bonus;
        }

        $decimal = $bonus - floor($bonus);
        return (mt_rand(0, 999999999) / 1000000000) < $decimal ? ceil($bonus) : floor($bonus);
    }

    /**
     * Attempts to guess a coefficient via newton's method with the given starting stat
     * value, desired end value, and maximum level.
     *
     * Actually, maybe just a fake newton's method since the real way would require me
     * to open my Calculus book and figure out how to get the derivative of a sum function
     * with the above stat bonus formula. Besides, this function probably isn't even going
     * to be executed outside of development.
     *
     * It works pretty good actually after some tests. I dub it the PLAN method
     * (Pure Lazy-ass Newton's Method) and hereby patent it, but not really.
     * Especially since it's just a limit function that returns the best result it
     * gets after 500 iterations.
     *
     * @param $startValue
     * @param $endValue
     * @param int $maxLevel
     * @return float|int
     */
    public static function guessCoefficient($startValue, $endValue, $maxLevel = 100)
    {
        $guess = function($coeff) use ($maxLevel, $startValue) {
            $sum = $startValue;
            for ( $i = 2; $i <= $maxLevel; $i++ ) {
                $sum += self::getStatBonus($coeff, $i, true);
            }
            return $sum;
        };

        $c = 1;
        $g = $guess($c);
        $epsilon = 1e-10;
        $iters = 0;
        while ( abs($endValue - $g) > $epsilon && $iters < 500 ) {
            $c += ($endValue - $g) / 10000;
            $g = $guess($c);
            echo "$c: $g<br>";
            $iters++;
        }

        return $c;
    }
}
