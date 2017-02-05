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

        $result = $messages->fromText($messageText);

        $this->assertInstanceOf(Message::class, $result);
    }
}