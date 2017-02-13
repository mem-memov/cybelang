<?php

namespace MemMemov\Cybe\Parser\PlainText;

use PHPUnit\Framework\TestCase;

class PlainTextMessagesTest extends TestCase
{
    /** @var PlainTextClauses|\PHPUnit_Framework_MockObject_MockObject */
    protected $clauses;

    protected function setUp()
    {
        $this->clauses = $this->createMock(PlainTextClauses::class);
    }

    public function testItCreatesMessage()
    {
        $messages = new PlainTextMessages($this->clauses);

        $string = 'врач.ставить(что:диагноз,кому:больной,когда:сейчас)';
        $string .= 'врач.лечить(кого:больной,отчего:болезнь,когда:врач.ставить.после)';
        $string .= 'лекарство.есть(какой:хороший)';
        $string .= 'врач.дать(что:лекарство,кому:больной)';

        $result = $messages->create($string);

        self::assertInstanceOf(PlainTextMessage::class, $result);
    }
}