<?php

namespace MemMemov\Cybe\Parser\Strings;

class ComplimentsTest extends \PHPUnit_Framework_TestCase
{
    public function testItCreatesCompliment()
    {
        $compliments = new Compliments();

        $string = 'диагноз';

        $compliment = $compliments->create($string);

        $this->assertInstanceOf(Compliment::class, $compliment);
    }
}