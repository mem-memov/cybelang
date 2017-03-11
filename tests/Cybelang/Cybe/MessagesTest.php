<?php

namespace MemMemov\Cybelang\Cybe;

use PHPUnit\Framework\TestCase;

class MessagesTest extends TestCase
{
    /** @var Graph|\PHPUnit_Framework_MockObject_MockObject */
    protected $graph;
    /** @var Clauses|\PHPUnit_Framework_MockObject_MockObject */
    protected $clauses;
    /** @var Contexts|\PHPUnit_Framework_MockObject_MockObject */
    protected $contexts;
    /** @var Statements|\PHPUnit_Framework_MockObject_MockObject */
    protected $statements;
    /** @var Utterances|\PHPUnit_Framework_MockObject_MockObject */
    protected $utterances;

    protected function setUp()
    {
        $this->graph = $this->createMock(Graph::class);
        $this->clauses = $this->createMock(Clauses::class);
        $this->contexts = $this->createMock(Contexts::class);
        $this->statements = $this->createMock(Statements::class);
        $this->utterances = $this->createMock(Utterances::class);
    }

    public function testItCreatesMessageFromText()
    {
        $messages = new Messages($this->graph, $this->clauses);
        $messages->setContexts($this->contexts);
        $messages->setStatements($this->statements);
        $messages->setUtterances($this->utterances);
        
        $messageText = $this->createMock(Parser\Message::class);

        $clauseText_1 = $this->createMock(Parser\Clause::class);
        $clauseText_2 = $this->createMock(Parser\Clause::class);

        $messageText->expects($this->once())
            ->method('clauses')
            ->willReturn([$clauseText_1, $clauseText_2]);

        $clause_1 = $this->createMock(Clause::class);
        $clause_2 = $this->createMock(Clause::class);

        $this->clauses->expects($this->exactly(2))
            ->method('fromText')
            ->withConsecutive(
                [$clauseText_1],
                [$clauseText_2]
            )
            ->will($this->onConsecutiveCalls($clause_1, $clause_2));
        ;

        $autor = $this->createMock(Author::class);
        
        $autor->expects($this->once())
            ->method('id')
            ->willReturn(120033005);
        
        $result = $messages->fromText($messageText, $autor);

        $this->assertInstanceOf(Message::class, $result);
    }
}