<?php

namespace MemMemov\Cybe\Parser\PlainText;

class PlainTextClausesTest extends \PHPUnit_Framework_TestCase
{
    /** @var PlainTextPredicates|\PHPUnit_Framework_MockObject_MockObject */
    protected $predicates;
    /** @var PlainTextSubjects|\PHPUnit_Framework_MockObject_MockObject */
    protected $subjects;
    /** @var PlainTextArguments|\PHPUnit_Framework_MockObject_MockObject */
    protected $arguments;

    protected function setUp()
    {
        $this->predicates = $this->getMockBuilder(PlainTextPredicates::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->subjects = $this->getMockBuilder(PlainTextSubjects::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->arguments = $this->getMockBuilder(PlainTextArguments::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testItCreatesClause()
    {
        $clauses = new PlainTextClauses($this->predicates, $this->subjects, $this->arguments);

        $string = 'врач.ставить(что:диагноз,кому:больной,когда:сейчас)';

        $clause = $clauses->create($string);

        $this->assertInstanceOf(PlainTextClause::class, $clause);
    }
}