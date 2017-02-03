<?php

namespace MemMemov\Cybe;

class ClausesTest extends \PHPUnit_Framework_TestCase
{
    public function testItCreatesClausesFromText()
    {
        $clauses = new Clauses();
        $text = 'врач.ставить(что:диагноз,кому:больной,кто:врач,когда:сейчас)';
        $text .= 'врач.лечить(кого:больной,отчего:болезнь,когда:врач.ставить.после)';
        $text .= 'лекарство.есть(какой:хороший)';
        $text .= 'врач.дать(что:лекарство,кому:больной)';
        $result = $clauses->fromText($text);
        $this->assertCount(4, $result);
        $this->assertContainsOnlyInstancesOf(Clause::class, $result);
    }
}