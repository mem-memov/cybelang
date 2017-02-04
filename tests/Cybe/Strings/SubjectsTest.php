<?php

namespace MemMemov\Cybe\Strings;

class SubjectsTest extends \PHPUnit_Framework_TestCase
{
    public function testItCreatesSubject()
    {
        $subjects = new Subjects();

        $result = $subjects->create();

        $this->assertInstanceOf(Subject::class, $result);
    }
}