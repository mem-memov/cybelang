<?php

namespace MemMemov\Cybe\Parser\PlainText;

class PlainTextArgumentTest extends \PHPUnit_Framework_TestCase
{
    /** @var PlainTextCategories|\PHPUnit_Framework_MockObject_MockObject */
    protected $categories;
    /** @var PlainTextCategories|\PHPUnit_Framework_MockObject_MockObject */
    protected $complements;

    protected function setUp()
    {
        $this->categories = $this->getMockBuilder(PlainTextCategories::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->complements = $this->getMockBuilder(PlainTextCompliments::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testItHasCategory()
    {
        $string = 'что:диагноз';

        $argument = new PlainTextArgument($this->categories, $this->complements, $string);

        $category = $this->getMockBuilder(PlainTextCategory::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->categories->expects($this->once())
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

        $compliment = $this->getMockBuilder(PlainTextCompliment::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->complements->expects($this->once())
            ->method('create')
            ->with('диагноз')
            ->willReturn($compliment);

        $result = $argument->compliment();

        $this->assertSame($compliment, $result);
    }
}