<?php

namespace MemMemov\Cybe;

use PHPUnit\Framework\TestCase;

class ClausesTest extends TestCase
{
    /** @var Predicates|\PHPUnit_Framework_MockObject_MockObject */
    protected $predicates;
    /** @var Subjects|\PHPUnit_Framework_MockObject_MockObject */
    protected $subjects;
    /** @var Arguments|\PHPUnit_Framework_MockObject_MockObject */
    protected $arguments;

    protected function setUp()
    {
        $this->predicates = $this->createMock(Predicates::class);
        $this->subjects = $this->createMock(Subjects::class);
        $this->arguments = $this->createMock(Arguments::class);
    }

    public function testItCreatesClauseFromText()
    {
        $clauses = new Clauses($this->predicates, $this->subjects, $this->arguments);

        $clauseText = $this->createMock(Parser\Clause::class);

        // predicate

        $predicateText = $this->createMock(Parser\Predicate::class);

        $clauseText->expects(self::once())
            ->method('predicate')
            ->willReturn($predicateText);

        $predicate = $this->createMock(Predicate::class);

        $this->predicates->expects(self::once())
            ->method('fromText')
            ->with($predicateText)
            ->willReturn($predicate);

        // subject

        $subjectText = $this->createMock(Parser\Subject::class);

        $clauseText->expects(self::once())
            ->method('subject')
            ->willReturn($subjectText);

        $subject = $this->createMock(Subject::class);

        $this->subjects->expects(self::once())
            ->method('fromText')
            ->with($subjectText)
            ->willReturn($subject);

        // arguments

        $argumentText_1 = $this->createMock(Parser\Argument::class);
        $argumentText_2 = $this->createMock(Parser\Argument::class);

        $clauseText->expects(self::once())
            ->method('arguments')
            ->with()
            ->willReturn([$argumentText_1, $argumentText_2]);

        $argument_1 = $this->createMock(Argument::class);
        $argument_2 = $this->createMock(Argument::class);

        $this->arguments->expects(self::exactly(2))
            ->method('fromText')
            ->withConsecutive(
                [$argumentText_1],
                [$argumentText_2]
            )
            ->will($this->onConsecutiveCalls($argument_1, $argument_2));

        $result = $clauses->fromText($clauseText);

        self::assertInstanceOf(Clause::class, $result);
    }
}