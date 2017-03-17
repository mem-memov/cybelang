<?php

namespace MemMemov\Cybelang\SpaceGraph\CommonNode;

use MemMemov\Cybelang\SpaceGraph\Node;
use MemMemov\Cybelang\SpaceGraph\Space\Space;
use MemMemov\Cybelang\SpaceGraph\Space\Spaces;
use PHPUnit\Framework\TestCase;

class ClustersTest extends TestCase
{
    /** @var Spaces|\PHPUnit_Framework_MockObject_MockObject */
    protected $spaces;

    protected function setUp()
    {
        $this->spaces = $this->createMock(Spaces::class);
    }

    public function testItCreatesClusterSet()
    {
        $clusters = new Clusters($this->spaces);

        $node_1 = $this->createMock(Node::class);
        $node_2 = $this->createMock(Node::class);

        $uniqueSpace = $this->createMock(Space::class);

        $this->spaces->expects($this->once())
            ->method('uniqueSpacesOfNodes')
            ->with([$node_1, $node_2])
            ->willReturn([$uniqueSpace]);

        $uniqueSpace->expects($this->once())
            ->method('filter')
            ->with([$node_1, $node_2])
            ->willReturn([$node_1]);

        $node_1->expects($this->once())
            ->method('id')
            ->willReturn(5);

        $result = $clusters->createClusterSet([$node_1, $node_2]);

        $this->assertInstanceOf(ClusterSet::class, $result);
    }

    public function testItForbidsCreatingEmptyClusterSet()
    {
        $clusters = new Clusters($this->spaces);

        $node_1 = $this->createMock(Node::class);
        $node_2 = $this->createMock(Node::class);

        $this->spaces->expects($this->once())
            ->method('uniqueSpacesOfNodes')
            ->with([$node_1, $node_2])
            ->willReturn([]);

        $this->expectException(ForbidEmptyClusterSet::class);

        $clusters->createClusterSet([$node_1, $node_2]);
    }
}