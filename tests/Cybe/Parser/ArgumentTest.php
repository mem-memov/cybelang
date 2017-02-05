<?php

namespace MemMemov\Cybe\Parser;

class ArgumentTest extends \PHPUnit_Framework_TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $categories;
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $complements;

    protected function setUp()
    {
        $this->categories = $this->getMockBuilder(Categories::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->complements = $this->getMockBuilder(Compliments::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testItHasCategory()
    {
        $string = 'что:диагноз';

        $argument = new Argument($this->categories, $this->complements, $string);

        $category = $this->getMockBuilder(Category::class)
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

        $argument = new Argument($this->categories, $this->complements, $string);

        $compliment = $this->getMockBuilder(Compliment::class)
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