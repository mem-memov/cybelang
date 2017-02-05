<?php

namespace MemMemov\Cybe;

class MessagesTest extends \PHPUnit_Framework_TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $clauses;

    protected function setUp()
    {
        $this->clauses = $this->getMockBuilder(Clauses::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testItCreatesMessageFromText()
    {
        $messages = new Messages($this->clauses);

        $messageText = $this->getMockBuilder(Parser\Message::class)
            ->disableOriginalConstructor()
            ->getMock();

        $clauseText_1 = $this->getMockBuilder(Parser\Clause::class)
            ->disableOriginalConstructor()
            ->getMock();

        $clauseText_2 = $this->getMockBuilder(Parser\Clause::class)
            ->disableOriginalConstructor()
            ->getMock();

        $messageText->expects($this->once())
            ->method('clauses')
            ->willReturn([$clauseText_1, $clauseText_2]);

        $clause_1 = $this->getMockBuilder(Clause::class)
            ->disableOriginalConstructor()
            ->getMock();

        $clause_2 = $this->getMockBuilder(Clause::class)
            ->disableOriginalConstructor()
            ->getMock();

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