<?php

namespace MemMemov\Cybe;

use PHPUnit\Framework\TestCase;

class ArgumentsTest extends TestCase
{
    /** @var Categories|\PHPUnit_Framework_MockObject_MockObject */
    protected $categories;
    /** @var Compliments|\PHPUnit_Framework_MockObject_MockObject */
    protected $compliments;

    protected function setUp()
    {
        $this->categories = $this->createMock(Categories::class);

        $this->compliments = $this->createMock(Compliments::class);
    }

    public function testItCreatesArgumentFromText()
    {
        $arguments = new Arguments($this->categories, $this->compliments);

        $argumentText = $this->createMock(Parser\Argument::class);

        // category

        $categoryText = $this->createMock(Parser\Category::class);

        $argumentText->expects(self::once())
            ->method('category')
            ->willReturn($categoryText);

        $category = $this->createMock(Category::class);

        $this->categories->expects(self::once())
            ->method('fromText')
            ->with($categoryText)
            ->willReturn($category);

        // compliment

        $complimentText = $this->createMock(Parser\Compliment::class);

        $argumentText->expects(self::once())
            ->method('compliment')
            ->willReturn($complimentText);

        $compliment = $this->createMock(Compliment::class);

        $this->compliments->expects(self::once())
            ->method('fromText')
            ->with($complimentText)
            ->willReturn($compliment);

        $result = $arguments->fromText($argumentText);

        self::assertInstanceOf(Argument::class, $result);
    }
}