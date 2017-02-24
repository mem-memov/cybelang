<?php

namespace MemMemov\Cybe\Parser\PlainText;

use PHPUnit\Framework\TestCase;
use MemMemov\Cybe\Parser\IClause;

class PlainTextMessageTest extends TestCase
{
    /** @var PlainTextClauses|\PHPUnit_Framework_MockObject_MockObject */
    protected $clauses;

    protected function setUp()
    {
        $this->clauses = $this->createMock(PlainTextClauses::class);
    }

    public function testItHasClauses()
    {
        $string = 'врач.ставить(что:диагноз,кому:больной,когда:сейчас)';
        $string .= 'врач.лечить(кого:больной,отчего:болезнь,когда:врач.ставить.после)';
        $string .= 'лекарство.есть(какой:хороший)';
        $string .= 'врач.дать(что:лекарство,кому:больной)';

        $message = new PlainTextMessage($this->clauses, $string);

        $clause_1 = $this->createMock(PlainTextClause::class);
        $clause_2 = $this->createMock(PlainTextClause::class);
        $clause_3 = $this->createMock(PlainTextClause::class);
        $clause_4 = $this->createMock(PlainTextClause::class);

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