<?php

namespace MemMemov\Cybe\Parser\PlainText;

class PlainTextComplimentsTest extends \PHPUnit\Framework\TestCase
{
    public function testItCreatesCompliment()
    {
        $compliments = new PlainTextCompliments();

        $string = 'диагноз';

        $compliment = $compliments->create($string);

        $this->assertInstanceOf(PlainTextCompliment::class, $compliment);
    }
}