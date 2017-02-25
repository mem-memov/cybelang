<?php

namespace MemMemov\Cybelang\Cybe;

use PHPUnit\Framework\TestCase;

class MessagesTest extends TestCase
{
    /** @var Clauses|\PHPUnit_Framework_MockObject_MockObject */
    protected $clauses;

    protected function setUp()
    {
        $this->clauses = $this->createMock(Clauses::class);
    }

    public function testItCreatesMessageFromText()
    {
        $messages = new Messages($this->clauses);

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

        $result = $messages->fromText($messageText);

        $this->assertInstanceOf(Message::class, $result);
    }
}