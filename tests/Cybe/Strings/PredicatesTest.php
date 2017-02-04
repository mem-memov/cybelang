<?php

namespace MemMemov\Cybe\Strings;

class PredicatesTest extends \PHPUnit_Framework_TestCase
{
    public function testItCreatesPredicate()
    {
        $predicates = new Predicates();

        $result = $predicates->create();

        $this->assertInstanceOf(Predicate::class, $result);
    }
}