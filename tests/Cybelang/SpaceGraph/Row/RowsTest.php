<?php

namespace MemMemov\Cybelang\SpaceGraph\Row;

use MemMemov\Cybelang\SpaceGraph\Node\Node;
use MemMemov\Cybelang\SpaceGraph\Node\Nodes;
use MemMemov\Cybelang\SpaceGraph\Space\Space;
use MemMemov\Cybelang\SpaceGraph\Space\Spaces;
use PHPUnit\Framework\TestCase;

class RowsTest extends TestCase
{
    /** @var Nodes|\PHPUnit_Framework_MockObject_MockObject */
    protected $nodes;
    /** @var Spaces|\PHPUnit_Framework_MockObject_MockObject */
    protected $spaces;

    protected function setUp()
    {
        $this->nodes = $this->createMock(Nodes::class);
        $this->spaces = $this->createMock(Spaces::class);        
    }
    
    public function testItCreatesRowUsingTailNodeId()
    {
        $rows = new Rows($this->nodes, $this->spaces);
        
        $headId = 89802;
        $tailSpaceName = 'message';
        
        $headNode = $this->createMock(Node::class);
        
        $this->nodes->expects($this->once())
            ->method('read')
            ->with($headId)
            ->willReturn($headNode);
        
        $tailSpace = $this->createMock(Space::class); 
        
        $this->spaces->expects($this->once())
            ->method('provideSpace')
            ->with($tailSpaceName)
            ->willReturn($tailSpace);
        
        $result = $rows->createUsingHead($headId, $tailSpaceName);
        
        $this->assertInstanceOf(Row::class, $result);
    }
}
