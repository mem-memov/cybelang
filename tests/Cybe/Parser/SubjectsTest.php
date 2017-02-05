<?php

namespace MemMemov\Cybe\Parser;

class SubjectsTest extends \PHPUnit_Framework_TestCase
{
    public function testItCreatesSubject()
    {
        $subjects = new Subjects();

        $string = 'врач';

        $result = $subjects->create($string);

        $this->assertInstanceOf(Subject::class, $result);
    }
}