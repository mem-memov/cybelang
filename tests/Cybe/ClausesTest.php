<?php

namespace MemMemov\Cybe;

class ClausesTest extends \PHPUnit_Framework_TestCase
{
    /** @var Predicates|\PHPUnit_Framework_MockObject_MockObject */
    protected $predicates;
    /** @var Subjects|\PHPUnit_Framework_MockObject_MockObject */
    protected $subjects;
    /** @var Arguments|\PHPUnit_Framework_MockObject_MockObject */
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

    public function testItCreatesClauseFromText()
    {
        $clauses = new Clauses($this->predicates, $this->subjects, $this->arguments);

        $clauseText = $this->createMock(Parser\Clause::class);

        // predicate

        $predicateText = $this->createMock(Parser\Predicate::class);

        $clauseText->expects($this->once())
            ->method('predicate')
            ->willReturn($predicateText);

        $predicate = $this->getMockBuilder(Predicate::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->predicates->expects($this->once())
            ->method('fromText')
            ->with($predicateText)
            ->willReturn($predicate);

        // subject

        $subjectText = $this->createMock(Parser\Subject::class);

        $clauseText->expects($this->once())
            ->method('subject')
            ->willReturn($subjectText);

        $subject = $this->getMockBuilder(Subject::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->subjects->expects($this->once())
            ->method('fromText')
            ->with($subjectText)
            ->willReturn($subject);

        // arguments

        $argumentText_1 = $this->createMock(Parser\Argument::class);
        $argumentText_2 = $this->createMock(Parser\Argument::class);

        $clauseText->expects($this->once())
            ->method('arguments')
            ->with()
            ->willReturn([$argumentText_1, $argumentText_2]);

        $argument_1 = $this->getMockBuilder(Argument::class)
            ->disableOriginalConstructor()
            ->getMock();

        $argument_2 = $this->getMockBuilder(Argument::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->arguments->expects($this->exactly(2))
            ->method('fromText')
            ->withConsecutive(
                [$argumentText_1],
                [$argumentText_2]
            )
            ->will($this->onConsecutiveCalls($argument_1, $argument_2));

        $result = $clauses->fromText($clauseText);

        $this->assertInstanceOf(Clause::class, $result);
    }
}