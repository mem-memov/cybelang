<?php

namespace MemMemov\Cybelang\Cybe\Parser\PlainText;

use PHPUnit\Framework\TestCase;

class PredicatesTest extends TestCase
{
    public function testItCreatesPredicate()
    {
        $predicates = new PlainTextPredicates();

        $string = 'ставить';

        $result = $predicates->create($string);

        $this->assertInstanceOf(PlainTextPredicate::class, $result);
    }
}