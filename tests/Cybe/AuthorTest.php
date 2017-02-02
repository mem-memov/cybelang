<?php

namespace MemMemov\Cybe;

class AuthorTest extends \PHPUnit_Framework_TestCase
{
    public function testItWritesMessage()
    {
        $author = new Author();

        $text = 'врач.ставить(что:диагноз,кому:больной,кто:врач,когда:сейчас)';
        $text .= 'врач.лечить(кого:больной,отчего:болезнь,когда:врач.ставить.после)';
        $text .= 'лекарство.есть(какое:хороший)';
        $text .= 'врач.дать(что:лекарство,кому:больной)';

        $author->write($text);
    }
}
