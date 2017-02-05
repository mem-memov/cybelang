<?php

namespace MemMemov\Cybe\Parser\PlainText;

class PlainTextComplimentsTest extends \PHPUnit_Framework_TestCase
{
    public function testItCreatesCompliment()
    {
        $compliments = new PlainTextCompliments();

        $string = 'диагноз';

        $compliment = $compliments->create($string);

        $this->assertInstanceOf(PlainTextCompliment::class, $compliment);
    }
}