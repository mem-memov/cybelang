<?php

namespace MemMemov\Cybe;

use PHPUnit\Framework\TestCase;

class ClausesTest extends TestCase
{
    /** @var Graph|\PHPUnit_Framework_MockObject_MockObject */
    protected $graph;
    /** @var Predicates|\PHPUnit_Framework_MockObject_MockObject */
    protected $predicates;
    /** @var Subjects|\PHPUnit_Framework_MockObject_MockObject */
    protected $subjects;
    /** @var Arguments|\PHPUnit_Framework_MockObject_MockObject */
    protected $arguments;

    protected function setUp()
    {
        $this->graph = $this->createMock(Graph::class);
        $this->predicates = $this->createMock(Predicates::class);
        $this->subjects = $this->createMock(Subjects::class);
        $this->arguments = $this->createMock(Arguments::class);
    }

    public function testItCreatesClauseFromText()
    {
        $clauses = new Clauses($this->graph, $this->subjects, $this->predicates, $this->arguments);

        $clauseText = $this->createMock(Parser\Clause::class);

        // subject

        $subjectText = $this->createMock(Parser\Subject::class);

        $clauseText->expects($this->once())
            ->method('subject')
            ->willReturn($subjectText);

        $subjectId = 22;
        $subject = $this->createMock(Subject::class);
        $subject->expects($this->once())
            ->method('id')
            ->willReturn($subjectId);

        $this->subjects->expects($this->once())
            ->method('fromText')
            ->with($subjectText)
            ->willReturn($subject);

        // predicate

        $predicateText = $this->createMock(Parser\Predicate::class);

        $clauseText->expects($this->once())
            ->method('predicate')
            ->willReturn($predicateText);

        $predicateId = 11;
        $predicate = $this->createMock(Predicate::class);
        $predicate->expects($this->once())
            ->method('id')
            ->willReturn($predicateId);

        $this->predicates->expects($this->once())
            ->method('fromText')
            ->with($predicateText)
            ->willReturn($predicate);

        // arguments

        $argumentText_1 = $this->createMock(Parser\Argument::class);
        $argumentText_2 = $this->createMock(Parser\Argument::class);

        $clauseText->expects($this->once())
            ->method('arguments')
            ->with()
            ->willReturn([$argumentText_1, $argumentText_2]);

        $argumentId_1 = 143521;
        $argument_1 = $this->createMock(Argument::class);
        $argument_1->expects($this->once())
            ->method('id')
            ->willReturn($argumentId_1);

        $argumentId_2 = 86756524;
        $argument_2 = $this->createMock(Argument::class);
        $argument_2->expects($this->once())
            ->method('id')
            ->willReturn($argumentId_2);

        $this->arguments->expects($this->exactly(2))
            ->method('fromText')
            ->withConsecutive(
                [$argumentText_1],
                [$argumentText_2]
            )
            ->will($this->onConsecutiveCalls($argument_1, $argument_2));

        $argumentNode = $this->createMock(GraphNode::class);
        $argumentNode->expects($this->once())
            ->method('id')
            ->willReturn(767);

        $this->graph->expects($this->once())
            ->method('provideCommonNode')
            ->with('clause', [$subjectId, $predicateId, $argumentId_1, $argumentId_2])
            ->willReturn($argumentNode);

        $result = $clauses->fromText($clauseText);

        $this->assertInstanceOf(Clause::class, $result);
    }
}