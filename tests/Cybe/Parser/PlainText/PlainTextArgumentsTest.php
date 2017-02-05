<?php

namespace MemMemov\Cybe\Parser\PlainText;

class PlainTextArgumentsTest extends \PHPUnit_Framework_TestCase
{
    /** @var PlainTextCategories|\PHPUnit_Framework_MockObject_MockObject */
    protected $categories;
    /** @var PlainTextCompliments|\PHPUnit_Framework_MockObject_MockObject */
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

    public function testItCreatesArgument()
    {
        $arguments = new PlainTextArguments($this->categories, $this->complements);

        $string = 'что:диагноз';

        $result = $arguments->create($string);

        $this->assertInstanceOf(PlainTextArgument::class, $result);
    }
}