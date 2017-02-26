<?php

namespace MemMemov\Cybelang\SpaceGraph;

use PHPUnit\Framework\TestCase;

class SpaceNodeTest extends TestCase
{
    /** @var Store|\PHPUnit_Framework_MockObject_MockObject */
    protected $id;
    /** @var SpaceNodesInNode|\PHPUnit_Framework_MockObject_MockObject */
    protected $spaceNodes;

    protected function setUp()
    {
        $this->id = 10;
        $this->spaceNodes = $this->createMock(SpaceNodesInNode::class);
    }

    public function testItSupplieId()
    {
        $spaceNode = new SpaceNode($this->id, $this->spaceNodes);

        $result = $spaceNode->id();

        $this->assertEquals($this->id, $result);
    }

    public function testItSuppliesOneSubnodeWithType()
    {
        $spaceNode = new SpaceNode($this->id, $this->spaceNodes);

        $type = 'clause';

        $subnode = $this->createMock(SpaceNode::class);

        $this->spaceNodes->expects($this->once())
            ->method('getOneNode')
            ->with($type)
            ->willReturn($subnode);

        $result = $spaceNode->one($type);

        $this->assertSame($subnode, $result);
    }

    public function testItSuppliesAllSubnodeWithType()
    {
        $spaceNode = new SpaceNode($this->id, $this->spaceNodes);

        $type = 'clause';

        $subnode = $this->createMock(SpaceNode::class);

        $this->spaceNodes->expects($this->once())
            ->method('findNodes')
            ->with($type, $this->id)
            ->willReturn([$subnode]);

        $result = $spaceNode->all($type);

        $this->assertSame([$subnode], $result);
    }
}