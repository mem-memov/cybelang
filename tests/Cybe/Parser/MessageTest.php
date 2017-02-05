<?php

namespace MemMemov\Cybe\Parser;

class MessageTest extends \PHPUnit_Framework_TestCase
{
    /** @var \PHPUnit_Framework_MockObject_MockObject */
    protected $clauses;

    protected function setUp()
    {
        $this->clauses = $this->getMockBuilder(Clauses::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testItHasClauses()
    {
        $string = 'врач.ставить(что:диагноз,кому:больной,когда:сейчас)';
        $string .= 'врач.лечить(кого:больной,отчего:болезнь,когда:врач.ставить.после)';
        $string .= 'лекарство.есть(какой:хороший)';
        $string .= 'врач.дать(что:лекарство,кому:больной)';

        $message = new Message($this->clauses, $string);

        $this->clauses->expects($this->exactly(4))
            ->method('create')
            ->withConsecutive(
                ['врач.ставить(что:диагноз,кому:больной,когда:сейчас)'],
                ['врач.лечить(кого:больной,отчего:болезнь,когда:врач.ставить.после)'],
                ['лекарство.есть(какой:хороший)'],
                ['врач.дать(что:лекарство,кому:больной)']
            );

        $result = $message->clauses();

        $this->assertContainsOnlyInstancesOf(Clause::class, $result);
    }
}