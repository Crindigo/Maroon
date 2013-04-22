<?php

namespace Maroon\RPGBundle\Tests\Util;

use Maroon\RPGBundle\Util\Calculator;

class CalculatorTest extends \PHPUnit_Framework_TestCase
{
    public function testSimple()
    {
        $this->assertEquals(4, Calculator::fromExpr('2 + 2')->result());

        $this->assertEquals(3, Calculator::fromExpr('5 - 2')->result());

        $this->assertEquals(10, Calculator::fromExpr('2 * 5')->result());

        $this->assertEquals(3, Calculator::fromExpr('15 / 5')->result());

        $this->assertEquals(4, Calculator::fromExpr('17 // 4')->result());
    }

    public function testWithParens()
    {
        $this->assertEquals(10, Calculator::fromExpr('(2 + 3) * 2')->result());
    }

    public function testSimpleEval()
    {
        $this->assertEquals(10, Calculator::fromExpr('(2 + 3) * x')->value('x', 2)->result());

        $this->assertEquals(10, Calculator::fromExpr('(2 + x) * y')->value(['x' => 3, 'y' => 2])->result());
    }

    public function testClosureEval()
    {
        $calc = Calculator::fromExpr('str * 2 + d')
            ->value('str', 30)
            ->value('d', function() { return 15; });

        $this->assertEquals(75, $calc->result());
    }

    public function testCompiled()
    {
        $comp = Calculator::fromExpr('(2 + 3) * x')->compile();
        $calc = Calculator::fromCompiled($comp)->value('x', 4);
        $this->assertEquals(20, $calc->result());
    }

    public function testRandomOperator()
    {
        Calculator::$enableCaching = true;
        for ( $i = 0; $i < 100; $i++ ) {
            $formula = '2 * 5 ~ 15';
            $result = Calculator::fromExpr($formula)->result();
            if ( $result < 10 || $result > 30 ) {
                $this->fail('Result was outside of random range');
            }
        }
    }

    public function testDiceOperator()
    {
        Calculator::$enableCaching = true;
        for ( $i = 0; $i < 100; $i++ ) {
            $formula = '2 # 6 + 10';
            $result = Calculator::fromExpr($formula)->result();
            if ( $result < 12 || $result > 22 ) {
                $this->fail('Dice result outside of range');
            }
        }
    }

    public function testScalar()
    {
        $this->assertEquals(5, Calculator::fromExpr('5')->result());
        $this->assertEquals(10, Calculator::fromExpr('ten')->value('ten', 10)->result());

        $this->assertEquals(['5'], Calculator::fromExpr('5')->compile());
    }

    public function testCompileRewrite()
    {
        $comp = Calculator::fromExpr('2 + 3')->compile();
        $comp = Calculator::negate($comp);
        $this->assertEquals(-5, Calculator::fromCompiled($comp)->result());

        $comp = Calculator::fromExpr('2 + 3')->compile();
        $comp2 = Calculator::fromExpr('5 + 4 * 3')->compile();

        $comp = Calculator::merge($comp, $comp2, '+');
        $this->assertEquals(22, Calculator::fromCompiled($comp)->result());

        $this->assertEquals(-22, Calculator::fromCompiled(Calculator::negate($comp))->result());
    }
}
