<?php

namespace App\Tests;

use App\Services\Calculator;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase
{
    public function testSomething(): void
    {
        $cal = new Calculator();
        $result = $cal->add(1,9);
        $this->assertEquals(11,$result);
    }
}
