<?php

namespace MemMemov\Cybelang\Cybe;

use PHPUnit\Framework\TestCase;

class ArgumentsTest extends TestCase
{
    /** @var Graph|\PHPUnit_Framework_MockObject_MockObject */
    protected $graph;
    /** @var Categories|\PHPUnit_Framework_MockObject_MockObject */
    protected $categories;
    /** @var Compliments|\PHPUnit_Framework_MockObject_MockObject */
    protected $compliments;

    protected function setUp()
    {
        $this->graph = $this->createMock(Graph::class);
        $this->categories = $this->createMock(Categories::class);
        $this->compliments = $this->createMock(Compliments::class);
    }

    public function testItCreatesArgumentFromText()
    {
        $arguments = new Arguments($this->graph, $this->categories, $this->compliments);

        $argumentText = $this->createMock(Parser\Argument::class);

        // category

        $categoryText = $this->createMock(Parser\Category::class);

        $argumentText->expects($this->once())
            ->method('category')
            ->willReturn($categoryText);

        $categoryId = 111;
        $category = $this->createMock(Category::class);
        $category->expects($this->once())
            ->method('id')
            ->willReturn($categoryId);

        $this->categories->expects($this->once())
            ->method('fromText')
            ->with($categoryText)
            ->willReturn($category);

        // compliment

        $complimentText = $this->createMock(Parser\Compliment::class);

        $argumentText->expects($this->once())
            ->method('compliment')
            ->willReturn($complimentText);

        $complimentId = 333;
        $compliment = $this->createMock(Compliment::class);
        $compliment->expects($this->once())
            ->method('id')
            ->willReturn($complimentId);

        $this->compliments->expects($this->once())
            ->method('fromText')
            ->with($complimentText)
            ->willReturn($compliment);

        $argumentNode = $this->createMock(GraphNode::class);
        $argumentNode->expects($this->once())
            ->method('id')
            ->willReturn(767);

        $this->graph->expects($this->once())
            ->method('provideCommonNode')
            ->with('argument', [$categoryId, $complimentId])
            ->willReturn($argumentNode);

        $result = $arguments->fromText($argumentText);

        $this->assertInstanceOf(Argument::class, $result);
    }
}