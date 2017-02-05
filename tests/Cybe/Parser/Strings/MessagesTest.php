<?php

namespace MemMemov\Cybe\Parser\Strings;

class MessagesTest extends \PHPUnit_Framework_TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $clauses;

    protected function setUp()
    {
        $this->clauses = $this->getMockBuilder(Clauses::class)
            ->disableOriginalConstructor()
            ->getMock($this->clauses);
    }

    public function testItCreatesMessage()
    {
        $messages = new Messages($this->clauses);

        $string = 'врач.ставить(что:диагноз,кому:больной,когда:сейчас)';
        $string .= 'врач.лечить(кого:больной,отчего:болезнь,когда:врач.ставить.после)';
        $string .= 'лекарство.есть(какой:хороший)';
        $string .= 'врач.дать(что:лекарство,кому:больной)';

        $result = $messages->create($string);

        $this->assertInstanceOf(Message::class, $result);
    }
}