<?php

namespace Maroon\RPGBundle\Util;

/**
 * Expression calculator that processes simple mathematical equations.
 *
 * $calc = Calculator::expr('str * 2 + damage')
 *             ->value('str', 30)
 *             ->value('damage', function() { return mt_rand(10, 20); })
 * $calc->result(); // -> 70-80, damage recalculated each call
 * $calc->compile(); // -> some structure that can be cached
 *
 * @package Maroon\RPGBundle\Util
 */
class Calculator
{
    /**
     * @var string
     */
    private $expression;

    /**
     * @var array
     */
    private $tokens = [];

    /**
     * @var array
     */
    private $compiled = [];

    /**
     * @var array
     */
    private $values = [];

    public static function fromExpr($expr)
    {
        $calc = new Calculator();
        $calc->expression = $expr;
        return $calc;
    }

    public static function fromCompiled($comp)
    {
        $calc = new Calculator();
        $calc->compiled = $comp;
        return $calc;
    }

    /**
     * @param array|string $key
     * @param null|number|\Closure $value
     * @return Calculator
     * @throws \InvalidArgumentException
     */
    public function value($key, $value = null)
    {
        if ( is_array($key) && $value === null ) {
            foreach ( $key as $k => $v ) {
                $this->value($k, $v);
            }
            return $this;
        }

        if ( !is_numeric($value) && !$value instanceof \Closure ) {
            throw new \InvalidArgumentException('Value must be numeric or a closure returning a numeric');
        }

        $this->values[$key] = $value;
        return $this;
    }

    private function getValue($key)
    {
        if ( is_numeric($this->values[$key]) ) {
            return $this->values[$key];
        } else if ( $this->values[$key] instanceof \Closure ) {
            $val = $this->values[$key]();
            if ( !is_numeric($val) ) {
                throw new \RuntimeException('Result of closure is non-numeric.');
            }
            return $val;
        }

        return 0;
    }

    public function result()
    {
        static $binaryOps = array('+', '-', '*', '/', '//', '%', '^', '>>', '<<');

        if ( empty($this->compiled) ) {
            $this->compile();
        }

        $pieces = $this->compiled;
        $stack = array();

        foreach ( $pieces as $p ) {
            if ( !in_array($p, $binaryOps) && !is_numeric($p) ) {
                $p = $this->getValue($p);
            }

            if ( is_numeric($p) ) {
                $stack[] = $p;
                continue;
            }

            if ( in_array($p, $binaryOps) ) {
                if ( count($stack) < 2 ) {
                    return false;
                }

                $v2 = array_pop($stack);
                $v1 = array_pop($stack);

                switch ( $p ) {
                    case '+' : $stack[] = $v1 + $v2; break;
                    case '-' : $stack[] = $v1 - $v2; break;
                    case '*' : $stack[] = $v1 * $v2; break;
                    case '/' : $stack[] = $v1 / $v2; break;
                    case '//': $stack[] = intval($v1 / $v2); break;
                    case '%' : $stack[] = $v1 % $v2; break;
                    case '^' : $stack[] = pow($v1, $v2); break;
                    case '>>': $stack[] = $v1 >> $v2; break;
                    case '<<': $stack[] = $v1 << $v2; break;
                }
            }
        }

        return $stack[0];
    }

    public function compile()
    {
        return $this->toPostfix();
    }

    private function tokenize()
    {
        $expr = $this->expression;
        $len = strlen($expr);
        $tokens = array();
        $tidx = 0;
        $state = 'ws'; // ws, op, paren, num, str
        $is_hex = false;

        for ( $i = 0; $i < $len; $i++ ) {
            $c = $expr[$i];
            if ( !isset($tokens[$tidx]) ) {
                $tokens[$tidx] = '';
            }

            if ( $c == '(' || $c == ')' ) {
                $tidx++;
                $tokens[$tidx] = $c;
                $state = 'ws';
                continue;
            }

            if ( $state == 'ws' ) { // white space
                if ( ctype_space($c) ) {
                    continue;
                } else if ( ctype_digit($c) || $c == '.'
                    || ($c == '-' && (ctype_digit($expr[$i+1]) || $expr[$i+1] == '.')) ) {
                    $tidx++;
                    $tokens[$tidx] = $c;
                    $state = 'num';
                } else if ( ctype_alpha($c) || $c == '_' ) {
                    $tidx++;
                    $tokens[$tidx] = $c;
                    $state = 'str';
                } else {
                    $tidx++;
                    $tokens[$tidx] = $c;
                    $state = 'op';
                }
            } else if ( $state == 'num' ) { // in a number
                if ( ctype_space($c) ) {
                    $tidx++;
                    $is_hex = false;
                    $state = 'ws';
                } else if ( ctype_digit($c) || $c == '.' ) {
                    $tokens[$tidx] .= $c;
                } else {
                    // check hexadecimal
                    if ( $tokens[$tidx] == '0' && ($c == 'x' || $c == 'X') ) {
                        $tokens[$tidx] .= $c;
                        $is_hex = true;
                    } else if ( $is_hex && ctype_xdigit($c) ) {
                        $tokens[$tidx] .= $c;
                    } else {
                        $tidx++;
                        $i--;
                        $state = 'op';
                    }
                }
            } else if ( $state == 'op' ) { // in an op
                if ( ctype_space($c) ) {
                    $tidx++;
                    $state = 'ws';
                } else if ( ctype_digit($c) || $c == '.' ) {
                    $tidx++;
                    $i--;
                    $state = 'num';
                } else if ( ctype_alpha($c) ) {
                    $tidx++;
                    $i--;
                    $state = 'str';
                } else {
                    $tokens[$tidx] .= $c;
                }
            } else if ( $state == 'str' ) { // in a string
                if ( ctype_space($c) ) {
                    $tidx++;
                    $state = 'ws';
                } else if ( ctype_alnum($c) || $c == '_' ) {
                    $tokens[$tidx] .= $c;
                } else {
                    $tidx++;
                    $i--;
                    $state = 'op';
                }
                // we can't go directly between num and str states, so don't bother (it'd be an error)
            }
        }

        for ( $i = count($tokens) - 1; $i >= 0; $i-- ) {
            if ( trim($tokens[$i]) == '' ) {
                unset($tokens[$i]);
            }
        }

        $this->tokens = array_values($tokens);
        return $this->tokens;
    }

    private function toPostfix()
    {
        static $operators = array('+', '-', '*', '/', '//', '%', '^', '>>', '<<');
        static $leftAssoc = array('+', '-', '*', '/', '//', '%', '>>', '<<');
        static $rightAssoc = array('^');
        static $prec = array(
            '+' => 2,
            '-' => 2,
            '*' => 3,
            '/' => 3,
            '//' => 3,
            '%' => 3,
            '^' => 4,
            '>>' => 1,
            '<<' => 1,
        );

        $tokens = $this->tokenize();
        $output = array();
        $opStack = array();

        foreach ( $tokens as $tok ) {
            $tok = trim($tok);
            if ( empty($tok) ) {
                continue;
            }

            if ( is_numeric($tok) ) {
                $output[] = strpos($tok, '.') !== false ? floatval($tok) : intval($tok);
            } else if ( in_array($tok, $operators) ) {
                while ( count($opStack) ) {
                    $top = end($opStack);
                    if ( !in_array($top, $operators) ) {
                        break;
                    }

                    if ( (in_array($tok, $leftAssoc) && $prec[$tok] <= $prec[$top])
                        || (in_array($tok, $rightAssoc) && $prec[$tok] < $prec[$top]) ) {
                        array_pop($opStack);
                        $output[] = $top;
                    } else {
                        break;
                    }
                }
                $opStack[] = $tok;
            } else if ( $tok == '(' ) {
                $opStack[] = $tok;
            } else if ( $tok == ')' ) {
                while ( ($op = array_pop($opStack)) !== null ) {
                    if ( $op != '(' ) {
                        $output[] = $op;
                    } else {
                        break;
                    }
                }
            } else {
                // placeholder string
                $output[] = $tok;
            }
        }

        while ( ($op = array_pop($opStack)) !== null ) {
            $output[] = $op;
        }

        $this->compiled = $output;
        return $this->compiled;
    }
}
