<?php

namespace MemMemov\Cybelang\Cybe;

use PHPUnit\Framework\TestCase;

class AuthorTest extends TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $parser;
    /** @var Messages|\PHPUnit_Framework_MockObject_MockObject */
    protected $messages;

    protected function setUp()
    {
        $this->parser = $this->createMock(Parser\Messages::class);
        $this->messages = $this->createMock(Messages::class);
    }

    public function testItWritesMessage()
    {
        $author = new Author($this->parser, $this->messages);

        $text = 'врач.ставить(что:диагноз,кому:больной,когда:сейчас)';
        $text .= 'врач.лечить(кого:больной,отчего:болезнь,когда:врач.ставить.после)';
        $text .= 'лекарство.есть(какой:хороший)';
        $text .= 'врач.дать(что:лекарство,кому:больной)';

        $messageText = $this->createMock(Parser\Message::class);

        $this->parser->expects($this->once())
            ->method('create')
            ->with($text)
            ->willReturn($messageText);

        $message = $this->createMock(Message::class);

        $this->messages->expects($this->once())
            ->method('fromText')
            ->with($messageText)
            ->willReturn($message);

        $author->write($text);
    }
}
