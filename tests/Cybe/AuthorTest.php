<?php

namespace MemMemov\Cybe;

class AuthorTest extends \PHPUnit_Framework_TestCase
{
    protected $clauses;

    protected function setUp()
    {
        $this->clauses = $this->getMockBuilder(Clauses::class)
            ->disableOriginalConstructor()
            ->getMock();
    }

    public function testItWritesMessage()
    {
        $author = new Author($this->clauses);

        $text = 'врач.ставить(что:диагноз,кому:больной,когда:сейчас)';
        $text .= 'врач.лечить(кого:больной,отчего:болезнь,когда:врач.ставить.после)';
        $text .= 'лекарство.есть(какой:хороший)';
        $text .= 'врач.дать(что:лекарство,кому:больной)';

        $this->clauses->expects($this->once())
            ->method('fromText')
            ->with($text);

        $author->write($text);
    }
}
