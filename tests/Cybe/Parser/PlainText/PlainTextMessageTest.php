<?php

namespace MemMemov\Cybe\Parser\PlainText;

use MemMemov\Cybe\Parser\IClause;

class PlainTextMessageTest extends \PHPUnit_Framework_TestCase
{
    /** @var PlainTextClauses|\PHPUnit_Framework_MockObject_MockObject */
    protected $clauses;

    protected function setUp()
    {
        $this->clauses = $this->getMockBuilder(PlainTextClauses::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testItHasClauses()
    {
        $string = 'врач.ставить(что:диагноз,кому:больной,когда:сейчас)';
        $string .= 'врач.лечить(кого:больной,отчего:болезнь,когда:врач.ставить.после)';
        $string .= 'лекарство.есть(какой:хороший)';
        $string .= 'врач.дать(что:лекарство,кому:больной)';

        $message = new PlainTextMessage($this->clauses, $string);

        $clause_1 = $this->getMockBuilder(PlainTextClause::class)
            ->disableOriginalConstructor()
            ->getMock();

        $clause_2 = $this->getMockBuilder(PlainTextClause::class)
            ->disableOriginalConstructor()
            ->getMock();

        $clause_3 = $this->getMockBuilder(PlainTextClause::class)
            ->disableOriginalConstructor()
            ->getMock();

        $clause_4 = $this->getMockBuilder(PlainTextClause::class)
            ->disableOriginalConstructor()
            ->getMock();

        $this->clauses->expects($this->exactly(4))
            ->method('create')
            ->withConsecutive(
                ['врач.ставить(что:диагноз,кому:больной,когда:сейчас)'],
                ['врач.лечить(кого:больной,отчего:болезнь,когда:врач.ставить.после)'],
                ['лекарство.есть(какой:хороший)'],
                ['врач.дать(что:лекарство,кому:больной)']
            )
            ->will($this->onConsecutiveCalls($clause_1, $clause_2, $clause_3, $clause_4));

        $result = $message->clauses();

        $this->assertSame([$clause_1, $clause_2, $clause_3, $clause_4], $result);
    }
}