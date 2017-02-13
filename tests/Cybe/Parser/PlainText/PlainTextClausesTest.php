<?php

namespace MemMemov\Cybe\Parser\PlainText;

use PHPUnit\Framework\TestCase;

class PlainTextClausesTest extends TestCase
{
    /** @var PlainTextPredicates|\PHPUnit_Framework_MockObject_MockObject */
    protected $predicates;
    /** @var PlainTextSubjects|\PHPUnit_Framework_MockObject_MockObject */
    protected $subjects;
    /** @var PlainTextArguments|\PHPUnit_Framework_MockObject_MockObject */
    protected $arguments;

    protected function setUp()
    {
        $this->predicates = $this->createMock(PlainTextPredicates::class);
        $this->subjects = $this->createMock(PlainTextSubjects::class);
        $this->arguments = $this->createMock(PlainTextArguments::class);
    }

    public function testItCreatesClause()
    {
        $clauses = new PlainTextClauses($this->predicates, $this->subjects, $this->arguments);

        $string = 'врач.ставить(что:диагноз,кому:больной,когда:сейчас)';

        $clause = $clauses->create($string);

        self::assertInstanceOf(PlainTextClause::class, $clause);
    }
}