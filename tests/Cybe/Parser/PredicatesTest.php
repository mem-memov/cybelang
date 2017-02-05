<?php

namespace MemMemov\Cybe\Parser;

class PredicatesTest extends \PHPUnit_Framework_TestCase
{
    public function testItCreatesPredicate()
    {
        $predicates = new Predicates();

        $string = 'ставить';

        $result = $predicates->create($string);

        $this->assertInstanceOf(Predicate::class, $result);
    }
}