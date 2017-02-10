<?php

namespace MemMemov\NodeStore;

class ArrayNodeStoreTest extends \PHPUnit_Framework_TestCase
{
    public function testItCreatesNode()
    {
        $store = new ArrayNodeStore();

        $result = $store->create();

        $this->assertEquals(1, $result);
    }
}