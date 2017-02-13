<?php

namespace MemMemov\Cybe\Parser\PlainText;

use PHPUnit\Framework\TestCase;

class PlainTextClauseTest extends TestCase
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

    public function testItHasPredicate()
    {
        $string = 'врач.ставить(что:диагноз,кому:больной,когда:сейчас)';

        $clause = new PlainTextClause($this->predicates, $this->subjects, $this->arguments, $string);

        $predicate = $this->createMock(PlainTextPredicate::class);

        $this->predicates->expects(self::once())
            ->method('create')
            ->with('ставить')
            ->willReturn($predicate);

        $result = $clause->predicate();

        self::assertSame($predicate, $result);
    }

    public function testItHasSubject()
    {
        $string = 'врач.ставить(что:диагноз,кому:больной,когда:сейчас)';

        $clause = new PlainTextClause($this->predicates, $this->subjects, $this->arguments, $string);

        $subject = $this->createMock(PlainTextSubject::class);

        $this->subjects->expects(self::once())
            ->method('create')
            ->with('врач')
            ->willReturn($subject);

        $result = $clause->subject();

        self::assertSame($subject, $result);
    }

    public function testItHasArguments()
    {
        $string = 'врач.ставить(что:диагноз,кому:больной,когда:сейчас)';

        $clause = new PlainTextClause($this->predicates, $this->subjects, $this->arguments, $string);

        $argument_1 = $this->createMock(PlainTextArgument::class);
        $argument_2 = $this->createMock(PlainTextArgument::class);
        $argument_3 = $this->createMock(PlainTextArgument::class);

        $this->arguments->expects(self::exactly(3))
            ->method('create')
            ->withConsecutive(
                ['что:диагноз'],
                ['кому:больной'],
                ['когда:сейчас']
            )
            ->will($this->onConsecutiveCalls($argument_1, $argument_2, $argument_3));

        $result = $clause->arguments();

        self::assertEquals([$argument_1, $argument_2, $argument_3], $result);
    }
}