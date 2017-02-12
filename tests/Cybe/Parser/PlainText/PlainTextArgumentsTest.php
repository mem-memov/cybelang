<?php

namespace MemMemov\Cybe\Parser\PlainText;

use PHPUnit\Framework\TestCase;

class PlainTextArgumentsTest extends TestCase
{
    /** @var PlainTextCategories|\PHPUnit_Framework_MockObject_MockObject */
    protected $categories;
    /** @var PlainTextCompliments|\PHPUnit_Framework_MockObject_MockObject */
    protected $complements;

    protected function setUp()
    {
        $this->categories = $this->createMock(PlainTextCategories::class);
        $this->complements = $this->createMock(PlainTextCompliments::class);
    }

    public function testItCreatesArgument()
    {
        $arguments = new PlainTextArguments($this->categories, $this->complements);

        $string = 'что:диагноз';

        $result = $arguments->create($string);

        $this->assertInstanceOf(PlainTextArgument::class, $result);
    }
}