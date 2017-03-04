<?php

namespace MemMemov\Cybelang\SpaceGraph;

use PHPUnit\Framework\TestCase;

class SpaceGraphsTest extends TestCase
{
    /** @var Store|\PHPUnit_Framework_MockObject_MockObject */
    protected $store;
    /** @var string */
    protected $rootName;
    
    protected function setUp()
    {
        $this->store = $this->createMock(Store::class);

        $this->rootName = '__node_space_root__';
    }
    
    public function testItCreatesSpaceGraph()
    {
        $spaceGraphs = new SpaceGraphs($this->store, $this->rootName);
        
        $result = $spaceGraphs->create();
        
        $this->assertInstanceOf(SpaceGraph::class, $result);
    }
}
