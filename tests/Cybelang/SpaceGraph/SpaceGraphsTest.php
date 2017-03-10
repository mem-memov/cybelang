<?php

namespace MemMemov\Cybelang\SpaceGraph;

use PHPUnit\Framework\TestCase;

class SpaceGraphsTest extends TestCase
{
    public function testItCreatesSpaceGraph()
    {
        $spaceGraphs = new SpaceGraphs();
        
        $store = $this->createMock(Store::class);
        $rootName = '__node_space_root__';
        
        $result = $spaceGraphs->create($store, $rootName);
        
        $this->assertInstanceOf(SpaceGraph::class, $result);
    }
}
