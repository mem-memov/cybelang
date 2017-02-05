<?php

namespace MemMemov\Cybe;

class ArgumentsTest extends \PHPUnit_Framework_TestCase
{
    /** @var Categories|\PHPUnit_Framework_MockObject_MockObject */
    protected $categories;
    /** @var Compliments|\PHPUnit_Framework_MockObject_MockObject */
    protected $compliments;

    protected function setUp()
    {
        $this->categories = $this->getMockBuilder(Categories::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->compliments = $this->getMockBuilder(Compliments::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testItCreatesArgumentFromText()
    {
        $arguments = new Arguments($this->categories, $this->compliments);

        $argumentText = $this->createMock(Parser\Argument::class);

        // category

        $categoryText = $this->createMock(Parser\Category::class);

        $argumentText->expects($this->once())
            ->method('category')
            ->willReturn($categoryText);

        $category = $this->getMockBuilder(Category::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->categories->expects($this->once())
            ->method('fromText')
            ->with($categoryText)
            ->willReturn($category);

        // compliment

        $complimentText = $this->createMock(Parser\Compliment::class);

        $argumentText->expects($this->once())
            ->method('compliment')
            ->willReturn($complimentText);

        $compliment = $this->getMockBuilder(Compliment::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->compliments->expects($this->once())
            ->method('fromText')
            ->with($complimentText)
            ->willReturn($compliment);

        $result = $arguments->fromText($argumentText);

        $this->assertInstanceOf(Argument::class, $result);
    }
}