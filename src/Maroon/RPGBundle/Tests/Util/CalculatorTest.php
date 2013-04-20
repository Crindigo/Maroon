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
}
