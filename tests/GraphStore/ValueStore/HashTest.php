<?php

namespace MemMemov\GraphStore\ValueStore;

use PHPUnit\Framework\TestCase;

class HashTest extends TestCase
{
    public function testItCreatesHash()
    {
        $hash = new Hash();

        $result = $hash->create('some value');

        $this->assertEquals($result, '5946210c9e93ae37891dfe96c3e39614');
    }
}