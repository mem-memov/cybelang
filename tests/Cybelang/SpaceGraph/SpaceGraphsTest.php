<?php

namespace MemMemov\Cybelang\SpaceGraph;

use MemMemov\Cybelang\SpaceGraph\Node\Store;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class SpaceGraphsTest extends TestCase
{
    public function testItCreatesSpaceGraph()
    {
        $spaceGraphs = new SpaceGraphs();
        
        $store = $this->createMock(Store::class);
        $rootName = '__node_space_root__';
        
        $logger = $this->createMock(LoggerInterface::class);
        $result = $spaceGraphs->create($store, $rootName, $logger);
        
        $this->assertInstanceOf(SpaceGraph::class, $result);
    }
}
