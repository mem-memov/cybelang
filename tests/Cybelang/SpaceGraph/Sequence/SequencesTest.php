<?php

namespace MemMemov\Cybelang\SpaceGraph\Sequence;

use MemMemov\Cybelang\SpaceGraph\Node;
use MemMemov\Cybelang\SpaceGraph\Nodes;
use PHPUnit\Framework\TestCase;

class SequencesTest extends TestCase
{
    /** @var Nodes|\PHPUnit_Framework_MockObject_MockObject */
    protected $nodes;
    /** @var SequenceTrees|\PHPUnit_Framework_MockObject_MockObject */
    protected $sequenceTrees;

    protected function setUp()
    {
        $this->nodes = $this->createMock(Nodes::class);
        $this->sequenceTrees = $this->createMock(SequenceTrees::class);
    }

    public function testItProvideSequenceNode()
    {
        $sequences = new Sequences($this->nodes, $this->sequenceTrees);

        $treeSpaceName = 'phrase';
        $ids = [330763];

        $sequenceNode = $this->createMock(Node::class);

        $this->nodes->expects($this->once())
            ->method('read')
            ->with($ids[0])
            ->willReturn($sequenceNode);

        $sequenceTree = $this->createMock(SequenceTree::class);

        $this->sequenceTrees->expects($this->once())
            ->method('create')
            ->with($treeSpaceName, [$sequenceNode])
            ->willReturn($sequenceTree);

        $treeNode = $this->createMock(Node::class);

        $sequenceTree->expects($this->once())
            ->method('getTreeNode')
            ->willReturn($treeNode);

        $result = $sequences->provideSequenceNode($treeSpaceName, $ids);

        $this->assertSame($treeNode, $result);
    }

    public function testItReadsNodeSequence()
    {
        $sequences = new Sequences($this->nodes, $this->sequenceTrees);

        $sequenceSpaceName = 'word';
        $treeNodeId = 6346043;

        $sequenceTree = $this->createMock(SequenceTree::class);

        $this->sequenceTrees->expects($this->once())
            ->method('get')
            ->with($sequenceSpaceName, $treeNodeId)
            ->willReturn($sequenceTree);

        $sequenceNode = $this->createMock(Node::class);

        $sequenceTree->expects($this->once())
            ->method('collectSequenceNodes')
            ->willReturn([$sequenceNode]);

        $result = $sequences->readNodeSequence($sequenceSpaceName, $treeNodeId);

        $this->assertSame([$sequenceNode], $result);
    }
}