<?php

namespace MemMemov\Cybe\Parser\PlainText;

class PredicatesTest extends \PHPUnit\Framework\TestCase
{
    public function testItCreatesPredicate()
    {
        $predicates = new PlainTextPredicates();

        $string = 'ставить';

        $result = $predicates->create($string);

        $this->assertInstanceOf(PlainTextPredicate::class, $result);
    }
}