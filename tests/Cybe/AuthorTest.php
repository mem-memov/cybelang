<?php

namespace MemMemov\Cybe;

class AuthorTest extends \PHPUnit_Framework_TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $parser;
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $messages;

    protected function setUp()
    {
        $this->parser = $this->getMockBuilder(Parser\Messages::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->messages = $this->getMockBuilder(Messages::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testItWritesMessage()
    {
        $author = new Author($this->parser, $this->messages);

        $text = 'врач.ставить(что:диагноз,кому:больной,когда:сейчас)';
        $text .= 'врач.лечить(кого:больной,отчего:болезнь,когда:врач.ставить.после)';
        $text .= 'лекарство.есть(какой:хороший)';
        $text .= 'врач.дать(что:лекарство,кому:больной)';

        $messageText = $this->getMockBuilder(Parser\Message::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->parser->expects($this->once())
            ->method('create')
            ->with($text)
            ->willReturn($messageText);

        $message = $this->getMockBuilder(Message::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->messages->expects($this->once())
            ->method('fromText')
            ->with($messageText)
            ->willReturn($message);

        $author->write($text);
    }
}
