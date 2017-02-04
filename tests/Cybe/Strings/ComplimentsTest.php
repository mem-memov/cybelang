<?php

namespace MemMemov\Cybe\Strings;

class ComplimentsTest extends \PHPUnit_Framework_TestCase
{
    public function testItCreatesCompliment()
    {
        $compliments = new Compliments();

        $compliment = $compliments->create();

        $this->assertInstanceOf(Compliment::class, $compliment);
    }
}