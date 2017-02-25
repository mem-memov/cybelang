<?php

namespace MemMemov\Cybelang\Cybe\Parser\PlainText;

use PHPUnit\Framework\TestCase;

class PlainTextComplimentsTest extends TestCase
{
    public function testItCreatesCompliment()
    {
        $compliments = new PlainTextCompliments();

        $string = 'диагноз';

        $compliment = $compliments->create($string);

        $this->assertInstanceOf(PlainTextCompliment::class, $compliment);
    }
}