<?php

/*
 * This file is part of Maroon (name not final).
 *
 * Maroon is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Maroon is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Maroon.  If not, see <http://www.gnu.org/licenses/>.
 */

namespace Maroon\Util;

/**
 * The NameGenerator class is responsible for generating random names from the mudnames
 * format. For a description of the format, see the documentation for parseMudNamesString.
 */
class NameGenerator
{
    /**
     * Parses a string representation of mudnames data into prefixes, suffixes, and middles.
     *
     * Data should look like:
     *
     *   #PRE
     *   Prefix1
     *   PrefixN
     *   #MID
     *   Middle1
     *   #SUF
     *   Suffix1
     *
     * @static
     * @param $string
     * @return array Array with 3 keys: pre, mid, suf. Prefixes, middles, suffixes respectively.
     */
    public static function parseMudNamesString($string)
    {
        $data = preg_split('/\r\n|\n|\r/', $string, -1, PREG_SPLIT_NO_EMPTY);
        $size = count($data);
        $type = '';

        $parts = array();
        $parts['pre'] = $parts['mid'] = $parts['suf'] = array();

        // parse the file into $parts
        for ( $i = 0; $i < $size; $i++ ) {
            switch ( trim($data[$i]) ) {
                case '#PRE': $type = 'pre'; break;
                case '#MID': $type = 'mid'; break;
                case '#SUF': $type = 'suf'; break;
                default:
                    $parts[$type][] = trim($data[$i]);
                    break;
            }
        }

        return $parts;
    }

    /**
     * Parses a mudnames file into prefixes, suffixes, middles.
     *
     * @see parseMudNamesString
     * @static
     * @param $file
     * @return array
     */
    public static function parseMudNamesFile($file)
    {
        return self::parseMudNamesString(file_get_contents($file));
    }

    /**
     * Generates a random name based on name prefixes, suffixes, and optionally middles.
     *
     * @static
     * @param array $prefixes
     * @param array $suffixes
     * @param array $middles
     * @return string
     */
    public static function generateNameFromParts(array $prefixes, array $suffixes, array $middles = array())
    {
        $pre = ucfirst($prefixes[ mt_rand(0, count($prefixes) - 1) ]);
        $mid = empty($middles) ? '' : $middles[ mt_rand(0, count($middles) - 1) ];
        $suf = $suffixes[ mt_rand(0, count($suffixes) - 1) ];

        return $pre . $mid . $suf;
    }

    /**
     * Generates a random name from the given mudnames file.
     *
     * @static
     * @param $file
     * @return string
     */
    public static function generateNameFromFile($file)
    {
        $parts = self::parseMudNamesFile($file);
        return self::generateNameFromParts($parts['pre'], $parts['suf'], $parts['mid']);
    }

    /**
     * Generates a random name from the given mudnames string data.
     *
     * @static
     * @param $string
     * @return string
     */
    public static function generateNameFromString($string)
    {
        $parts = self::parseMudNamesString($string);
        return self::generateNameFromParts($parts['pre'], $parts['suf'], $parts['mid']);
    }
}
