<?php

namespace MemMemov\Cybe\Parser\PlainText;

use PHPUnit\Framework\TestCase;

class SubjectsTest extends TestCase
{
    public function testItCreatesSubject()
    {
        $subjects = new PlainTextSubjects();

        $string = 'врач';

        $result = $subjects->create($string);

        $this->assertInstanceOf(PlainTextSubject::class, $result);
    }
}