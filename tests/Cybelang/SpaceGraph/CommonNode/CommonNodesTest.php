<?php

namespace MemMemov\Cybelang\SpaceGraph\CommonNode;

use MemMemov\Cybelang\SpaceGraph\Node\{Node, Nodes};
use MemMemov\Cybelang\SpaceGraph\Space\Space;
use PHPUnit\Framework\TestCase;

class CommonNodesTest  extends TestCase
{
    /** @var Nodes|\PHPUnit_Framework_MockObject_MockObject */
    protected $nodes;
    /** @var Clusters|\PHPUnit_Framework_MockObject_MockObject */
    protected $clusters;
    
    protected function setUp()
    {
        $this->nodes = $this->createMock(Nodes::class);
        $this->clusters = $this->createMock(Clusters::class);
    }
    
    public function testItProvidesMatchingCommonNodes()
    {
        $commonNodes = new CommonNodes($this->nodes, $this->clusters);
        
        $space = $this->createMock(Space::class);
        $ids = [538001];
        
        $node = $this->createMock(Node::class);
        
        $this->nodes->expects($this->once())
            ->method('readMany')
            ->with($ids)
            ->willReturn([$node]);
        
        $masterClusterSet = $this->createMock(ClusterSet::class);
        
        $this->clusters->expects($this->at(0))
            ->method('createClusterSet')
            ->with([$node])
            ->willReturn($masterClusterSet);
        
        $commonNode = $this->createMock(Node::class);
        
        $this->nodes->expects($this->once())
            ->method('commonNodes')
            ->with($ids)
            ->willReturn([$commonNode]);
        
        $space->expects($this->once())
            ->method('filter')
            ->with([$commonNode])
            ->willReturn([$commonNode]);

        $commonNode->expects($this->once())
            ->method('all')
            ->willReturn([$node]);
        
        $clusterSet = $this->createMock(ClusterSet::class);
        
        $this->clusters->expects($this->at(1))
            ->method('createClusterSet')
            ->with([$node])
            ->willReturn($clusterSet);
        
        $masterClusterSet->expects($this->once())
            ->method('inClusterSet')
            ->with($clusterSet)
            ->willReturn(true);
        
        $result = $commonNodes->provideMatchingCommonNodes($space, $ids);
        
        $this->assertSame([$commonNode], $result);
    }
    
    public function testItDoesNotProvideMatchingCommonNodes()
    {
        $commonNodes = new CommonNodes($this->nodes, $this->clusters);
        
        $space = $this->createMock(Space::class);
        $ids = [538001];
        
        $node = $this->createMock(Node::class);
        
        $this->nodes->expects($this->once())
            ->method('readMany')
            ->with($ids)
            ->willReturn([$node]);
        
        $masterClusterSet = $this->createMock(ClusterSet::class);
        
        $this->clusters->expects($this->at(0))
            ->method('createClusterSet')
            ->with([$node])
            ->willReturn($masterClusterSet);
        
        $commonNode = $this->createMock(Node::class);
        
        $this->nodes->expects($this->once())
            ->method('commonNodes')
            ->with($ids)
            ->willReturn([$commonNode]);
        
        $space->expects($this->once())
            ->method('filter')
            ->with([$commonNode])
            ->willReturn([$commonNode]);

        $commonNode->expects($this->once())
            ->method('all')
            ->willReturn([$node]);
        
        $clusterSet = $this->createMock(ClusterSet::class);
        
        $this->clusters->expects($this->at(1))
            ->method('createClusterSet')
            ->with([$node])
            ->willReturn($clusterSet);
        
        $masterClusterSet->expects($this->once())
            ->method('inClusterSet')
            ->with($clusterSet)
            ->willReturn(false);
        
        $result = $commonNodes->provideMatchingCommonNodes($space, $ids);
        
        $this->assertSame([], $result);
    }
}
