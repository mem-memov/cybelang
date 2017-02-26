<?php

namespace MemMemov\Cybelang\SpaceGraph;

use PHPUnit\Framework\TestCase;

class SpaceNodesTest extends TestCase
{
    /** @var Nodes|\PHPUnit_Framework_MockObject_MockObject */
    protected $nodes;
    /** @var Spaces|\PHPUnit_Framework_MockObject_MockObject */
    protected $spaces;
    /** @var CommonNodes|\PHPUnit_Framework_MockObject_MockObject */
    protected $commonNodes;

    protected function setUp()
    {
        $this->nodes = $this->createMock(Nodes::class);
        $this->spaces = $this->createMock(Spaces::class);
        $this->commonNodes = $this->createMock(CommonNodes::class);
    }

    public function testItReadsNodeWithId()
    {
        $spaceNodes = new SpaceNodes($this->nodes, $this->spaces, $this->commonNodes);

        $id = 2;

        $node = $this->createMock(Node::class);

        $this->nodes->expects($this->once())
            ->method('read')
            ->with($id)
            ->willReturn($node);

        $result = $spaceNodes->readNode($id);

        $this->assertInstanceOf(SpaceNode::class, $result);
    }

    public function testItReadsCommonNode()
    {
        $spaceNodes = new SpaceNodes($this->nodes, $this->spaces, $this->commonNodes);

        $spaceName = 'clause';
        $ids = [10];

        $space = $this->createMock(Space::class);

        $this->spaces->expects($this->once())
            ->method('provideSpace')
            ->with($spaceName)
            ->willReturn($space);

        $node = $this->createMock(Node::class);

        $this->commonNodes->expects($this->once())
            ->method('provideMatchingCommonNodes')
            ->with($space, $ids)
            ->willReturn([$node]);

        $space->expects($this->once())
            ->method('has')
            ->with($node)
            ->willReturn(true);

        $result = $spaceNodes->provideCommonNode($spaceName, $ids);

        $this->assertInstanceOf(SpaceNode::class, $result);
    }
}