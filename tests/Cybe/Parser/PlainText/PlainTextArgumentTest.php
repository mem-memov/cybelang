<?php

namespace MemMemov\Cybe\Parser\PlainText;

use PHPUnit\Framework\TestCase;

class PlainTextArgumentTest extends TestCase
{
    /** @var PlainTextCategories|\PHPUnit_Framework_MockObject_MockObject */
    protected $categories;
    /** @var PlainTextCategories|\PHPUnit_Framework_MockObject_MockObject */
    protected $complements;

    protected function setUp()
    {
        $this->categories = $this->createMock(PlainTextCategories::class);
        $this->complements = $this->createMock(PlainTextCompliments::class);
    }

    public function testItHasCategory()
    {
        $string = 'что:диагноз';

        $argument = new PlainTextArgument($this->categories, $this->complements, $string);

        $category = $this->createMock(PlainTextCategory::class);

        $this->categories->expects(self::once())
            ->method('create')
            ->with('что')
            ->willReturn($category);

        $result = $argument->category();

        $this->assertSame($category, $result);
    }

    public function testItHasCompliment()
    {
        $string = 'что:диагноз';

        $argument = new PlainTextArgument($this->categories, $this->complements, $string);

        $compliment = $this->createMock(PlainTextCompliment::class);

        $this->complements->expects(self::once())
            ->method('create')
            ->with('диагноз')
            ->willReturn($compliment);

        $result = $argument->compliment();

        $this->assertSame($compliment, $result);
    }
}