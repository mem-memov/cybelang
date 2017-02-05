<?php

namespace MemMemov\Cybe\Parser\PlainText;

class SubjectsTest extends \PHPUnit_Framework_TestCase
{
    public function testItCreatesSubject()
    {
        $subjects = new PlainTextSubjects();

        $string = 'врач';

        $result = $subjects->create($string);

        $this->assertInstanceOf(PlainTextSubject::class, $result);
    }
}