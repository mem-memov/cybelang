<?php

namespace MemMemov\Cybe\Parser;

class ClausesTest extends \PHPUnit_Framework_TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $predicates;
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $subjects;
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $arguments;

    protected function setUp()
    {
        $this->predicates = $this->getMockBuilder(Predicates::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->subjects = $this->getMockBuilder(Subjects::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->arguments = $this->getMockBuilder(Arguments::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testItCreatesClause()
    {
        $clauses = new Clauses($this->predicates, $this->subjects, $this->arguments);

        $string = 'врач.ставить(что:диагноз,кому:больной,когда:сейчас)';

        $clause = $clauses->create($string);

        $this->assertInstanceOf(Clause::class, $clause);
    }
}