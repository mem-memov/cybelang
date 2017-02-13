<?php

namespace MemMemov\Cybe\Parser\PlainText;

use PHPUnit\Framework\TestCase;

class PredicatesTest extends TestCase
{
    public function testItCreatesPredicate()
    {
        $predicates = new PlainTextPredicates();

        $string = 'ставить';

        $result = $predicates->create($string);

        self::assertInstanceOf(PlainTextPredicate::class, $result);
    }
}