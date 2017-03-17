<?php

namespace MemMemov\Cybelang\SpaceGraph;

use MemMemov\Cybelang\SpaceGraph\CommonNode\CommonNodes;
use MemMemov\Cybelang\SpaceGraph\CommonNode\ForbidMultipleCommonNodes;
use MemMemov\Cybelang\SpaceGraph\Row\Row;
use MemMemov\Cybelang\SpaceGraph\Row\Rows;
use MemMemov\Cybelang\SpaceGraph\Sequence\Sequences;
use MemMemov\Cybelang\SpaceGraph\Space\NodeNotFoundInSpace;
use MemMemov\Cybelang\SpaceGraph\Space\Space;
use MemMemov\Cybelang\SpaceGraph\Space\Spaces;
use PHPUnit\Framework\TestCase;

class SpaceNodesTest extends TestCase
{
    /** @var Nodes|\PHPUnit_Framework_MockObject_MockObject */
    protected $nodes;
    /** @var Spaces|\PHPUnit_Framework_MockObject_MockObject */
    protected $spaces;
    /** @var CommonNodes|\PHPUnit_Framework_MockObject_MockObject */
    protected $commonNodes;
    /** @var Sequences|\PHPUnit_Framework_MockObject_MockObject */
    protected $sequences;
    /** @var Rows|\PHPUnit_Framework_MockObject_MockObject */
    protected $rows;

    protected function setUp()
    {
        $this->nodes = $this->createMock(Nodes::class);
        $this->spaces = $this->createMock(Spaces::class);
        $this->commonNodes = $this->createMock(CommonNodes::class);
        $this->sequences = $this->createMock(Sequences::class);
        $this->rows = $this->createMock(Rows::class);
    }

    public function testItReadsNodeWithId()
    {
        $spaceNodes = new SpaceNodes($this->nodes, $this->spaces, $this->commonNodes, $this->sequences, $this->rows);

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
        $spaceNodes = new SpaceNodes($this->nodes, $this->spaces, $this->commonNodes, $this->sequences, $this->rows);

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

    public function testItForbidsUsingNodeFromDifferentSpaceWhenReadingCommonNode()
    {
        $spaceNodes = new SpaceNodes($this->nodes, $this->spaces, $this->commonNodes, $this->sequences, $this->rows);

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
            ->willReturn(false);

        $this->expectException(NodeNotFoundInSpace::class);

        $spaceNodes->provideCommonNode($spaceName, $ids);
    }

    public function testItCreatesCommonNode()
    {
        $spaceNodes = new SpaceNodes($this->nodes, $this->spaces, $this->commonNodes, $this->sequences, $this->rows);

        $spaceName = 'clause';
        $ids = [10];

        $space = $this->createMock(Space::class);

        $this->spaces->expects($this->once())
            ->method('provideSpace')
            ->with($spaceName)
            ->willReturn($space);

        $this->commonNodes->expects($this->once())
            ->method('provideMatchingCommonNodes')
            ->with($space, $ids)
            ->willReturn([]);

        $node = $this->createMock(Node::class);

        $this->nodes->expects($this->once())
            ->method('readMany')
            ->with($ids)
            ->willReturn([$node]);

        $commonNode = $this->createMock(Node::class);

        $space->expects($this->once())
            ->method('createCommonNode')
            ->with([$node])
            ->willReturn($commonNode);

        $commonNode->expects($this->once())
            ->method('id')
            ->willReturn(33000);

        $result = $spaceNodes->provideCommonNode($spaceName, $ids);

        $this->assertInstanceOf(SpaceNode::class, $result);
    }

    public function testItForbidsMultipleCommonNodes()
    {
        $spaceNodes = new SpaceNodes($this->nodes, $this->spaces, $this->commonNodes, $this->sequences, $this->rows);

        $spaceName = 'clause';
        $ids = [10];

        $space = $this->createMock(Space::class);

        $this->spaces->expects($this->once())
            ->method('provideSpace')
            ->with($spaceName)
            ->willReturn($space);

        $node_1 = $this->createMock(Node::class);
        $node_2 = $this->createMock(Node::class);

        $this->commonNodes->expects($this->once())
            ->method('provideMatchingCommonNodes')
            ->with($space, $ids)
            ->willReturn([$node_1, $node_2]);

        $this->expectException(ForbidMultipleCommonNodes::class);

        $spaceNodes->provideCommonNode($spaceName, $ids);
    }

    public function testItSuppliesOneNode()
    {
        $spaceNodes = new SpaceNodes($this->nodes, $this->spaces, $this->commonNodes, $this->sequences, $this->rows);

        $spaceName = 'clause';
        $id = 8;

        $containerNode = $this->createMock(Node::class);

        $this->nodes->expects($this->once())
            ->method('read')
            ->with($id)
            ->willReturn($containerNode);

        $space = $this->createMock(Space::class);

        $this->spaces->expects($this->once())
            ->method('provideSpace')
            ->with($spaceName)
            ->willReturn($space);

        $node = $this->createMock(Node::class);

        $space->expects($this->once())
            ->method('getOneNode')
            ->with($containerNode)
            ->willReturn($node);

        $node->expects($this->once())
            ->method('id')
            ->willReturn(78);

        $result = $spaceNodes->getOneNode($spaceName, $id);

        $this->assertInstanceOf(SpaceNode::class, $result);
    }

    public function testItFindsSubnodesWithNamespace()
    {
        $spaceNodes = new SpaceNodes($this->nodes, $this->spaces, $this->commonNodes, $this->sequences, $this->rows);

        $spaceName = 'clause';
        $id = 8;

        $containerNode = $this->createMock(Node::class);

        $this->nodes->expects($this->once())
            ->method('read')
            ->with($id)
            ->willReturn($containerNode);

        $space = $this->createMock(Space::class);

        $this->spaces->expects($this->once())
            ->method('provideSpace')
            ->with($spaceName)
            ->willReturn($space);

        $node = $this->createMock(Node::class);

        $space->expects($this->once())
            ->method('findNodes')
            ->with($containerNode)
            ->willReturn([$node]);

        $node->expects($this->once())
            ->method('id')
            ->willReturn(78);

        $result = $spaceNodes->findNodes($spaceName, $id);

        $this->assertContainsOnlyInstancesOf(SpaceNode::class, $result);
    }

    public function testItProvidesNodeForValue()
    {
        $spaceNodes = new SpaceNodes($this->nodes, $this->spaces, $this->commonNodes, $this->sequences, $this->rows);

        $spaceName = 'word';
        $value = 'dog';

        $space = $this->createMock(Space::class);

        $this->spaces->expects($this->once())
            ->method('provideSpace')
            ->with($spaceName)
            ->willReturn($space);

        $node = $this->createMock(Node::class);

        $space->expects($this->once())
            ->method('createNodeForValue')
            ->with($value)
            ->willReturn($node);

        $node->expects($this->once())
            ->method('id')
            ->willReturn(78);

        $result = $spaceNodes->provideNodeForValue($spaceName, $value);

        $this->assertInstanceOf(SpaceNode::class, $result);
    }

    public function testItSuppliesValueForNode()
    {
        $spaceNodes = new SpaceNodes($this->nodes, $this->spaces, $this->commonNodes, $this->sequences, $this->rows);

        $id = 598;
        $value = 'cat';

        $node = $this->createMock(Node::class);

        $this->nodes->expects($this->once())
            ->method('read')
            ->with($id)
            ->willReturn($node);

        $this->nodes->expects($this->once())
            ->method('valueForNode')
            ->with($node)
            ->willReturn($value);

        $result = $spaceNodes->valueOfNode($id);

        $this->assertEquals($value, $result);
    }

    public function testItProvidesSequenceNode()
    {
        $spaceNodes = new SpaceNodes($this->nodes, $this->spaces, $this->commonNodes, $this->sequences, $this->rows);

        $spaceName = 'clause';
        $ids = [10];

        $lastNode = $this->createMock(Node::class);

        $this->sequences->expects($this->once())
            ->method('provideSequenceNode')
            ->with($spaceName, $ids)
            ->willReturn($lastNode);

        $lastNode->expects($this->once())
            ->method('id')
            ->willReturn(78);

        $result = $spaceNodes->provideSequenceNode($spaceName, $ids);

        $this->assertInstanceOf(SpaceNode::class, $result);
    }

    public function testItReadsNodeSequence()
    {
        $spaceNodes = new SpaceNodes($this->nodes, $this->spaces, $this->commonNodes, $this->sequences, $this->rows);

        $spaceName = 'clause';
        $id = 78;

        $node = $this->createMock(Node::class);

        $this->sequences->expects($this->once())
            ->method('readNodeSequence')
            ->with($spaceName, $id)
            ->willReturn([$node]);

        $node->expects($this->once())
            ->method('id')
            ->willReturn(10);

        $result = $spaceNodes->readNodeSequence($spaceName, $id);

        $this->assertContainsOnlyInstancesOf(SpaceNode::class, $result);
    }
    
    public function testItAddsTailNodeToRow()
    {
        $spaceNodes = new SpaceNodes($this->nodes, $this->spaces, $this->commonNodes, $this->sequences, $this->rows);

        $headId = 33;
        $newTailId = 203003;
        $tailSpaceName = 'message';
        
        $newTailNode = $this->createMock(Node::class);
        
        $this->nodes->expects($this->once())
            ->method('read')
            ->with($newTailId)
            ->willReturn($newTailNode);
        
        $tailSpace = $this->createMock(Space::class);
        
        $this->spaces->expects($this->once())
            ->method('spaceOfNode')
            ->with($newTailNode)
            ->willReturn($tailSpace);
        
        $tailSpace->expects($this->once())
            ->method('name')
            ->willReturn($tailSpaceName);
        
        $row = $this->createMock(Row::class);
        
        $this->rows->expects($this->once())
            ->method('createUsingHead')
            ->with($headId, $tailSpaceName)
            ->willReturn($row);
        
        $row->expects($this->once())
            ->method('grow')
            ->with($newTailNode);
        
        $spaceNodes->addNodeToRow($headId, $newTailId);
    }
    
    public function testItReadsTailNodesFromRow()
    {
        $spaceNodes = new SpaceNodes($this->nodes, $this->spaces, $this->commonNodes, $this->sequences, $this->rows);
        
        $headId = 33;
        $tailSpaceName = 'message';
        $limit = 5;
        
        $row = $this->createMock(Row::class);
        
        $this->rows->expects($this->once())
            ->method('createUsingHead')
            ->with($headId, $tailSpaceName)
            ->willReturn($row);
        
        $tailNode = $this->createMock(Node::class);
        
        $row->expects($this->once())
            ->method('show')
            ->with($limit)
            ->willReturn([$tailNode]);
        
        $tailNode->expects($this->once())
            ->method('id')
            ->willReturn(429103218);
        
        $result = $spaceNodes->readRow($tailSpaceName, $headId, $limit);
        
        $this->assertContainsOnlyInstancesOf(SpaceNode::class, $result);
    }
}