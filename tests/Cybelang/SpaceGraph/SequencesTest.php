<?php

namespace MemMemov\Cybelang\SpaceGraph;

use PHPUnit\Framework\TestCase;

class SequencesTest extends TestCase
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

    public function testItForbidsSequencingMultipleSpaces()
    {
        $sequences = new Sequences($this->nodes, $this->spaces);

        $spaceName = 'clause';
        $ids = [533];

        $space = $this->createMock(Space::class);

        $this->spaces->expects($this->once())
            ->method('provideSpace')
            ->with($spaceName)
            ->willReturn($space);

        $node = $this->createMock(Node::class);

        $this->nodes->expects($this->once())
            ->method('read')
            ->with(533)
            ->willReturn($node);

        $this->spaces->expects($this->once())
            ->method('inSameSpace')
            ->with([$node])
            ->willReturn(false);

        $this->expectException(ForbidSequencingMultipleSpaces::class);

        $sequences->provideSequenceNode($spaceName, $ids);
    }

    public function testItProvidesFirstNodeInSequence()
    {
        $sequences = new Sequences($this->nodes, $this->spaces);

        $spaceName = 'clause';
        $ids = [533];

        $space = $this->createMock(Space::class);

        $this->spaces->expects($this->once())
            ->method('provideSpace')
            ->with($spaceName)
            ->willReturn($space);

        $node = $this->createMock(Node::class);

        $this->nodes->expects($this->once())
            ->method('read')
            ->with(533)
            ->willReturn($node);

        $this->spaces->expects($this->once())
            ->method('inSameSpace')
            ->with([$node])
            ->willReturn(true);

        $firstSequenceNode = $this->createMock(Node::class);

        $space->expects($this->once())
            ->method('createCommonNode')
            ->with([$node])
            ->willReturn($firstSequenceNode);

        $result = $sequences->provideSequenceNode($spaceName, $ids);

        $this->assertSame($firstSequenceNode, $result);
    }

    public function testItProvidesLastNodeInSequence()
    {
        $sequences = new Sequences($this->nodes, $this->spaces);

        $spaceName = 'clause';
        $ids = [533, 17, 8735];

        $space = $this->createMock(Space::class);

        $this->spaces->expects($this->once())
            ->method('provideSpace')
            ->with($spaceName)
            ->willReturn($space);

        $node_1 = $this->createMock(Node::class);
        $node_2 = $this->createMock(Node::class);
        $node_3 = $this->createMock(Node::class);

        $this->nodes->expects($this->exactly(3))
            ->method('read')
            ->withConsecutive([533], [17], [8735])
            ->will($this->onConsecutiveCalls($node_1, $node_2, $node_3));

        $this->spaces->expects($this->once())
            ->method('inSameSpace')
            ->with([$node_1, $node_2, $node_3])
            ->willReturn(true);

        $sequenceNode_1 = $this->createMock(Node::class);
        $sequenceNode_2 = $this->createMock(Node::class);
        $sequenceNode_3 = $this->createMock(Node::class);

        $space->expects($this->exactly(3))
            ->method('createCommonNode')
            ->withConsecutive([[$node_1]], [[$sequenceNode_1, $node_2]], [[$sequenceNode_2, $node_3]])
            ->will($this->onConsecutiveCalls($sequenceNode_1, $sequenceNode_2, $sequenceNode_3));

        $result = $sequences->provideSequenceNode($spaceName, $ids);

        $this->assertSame($sequenceNode_3, $result);
    }
}