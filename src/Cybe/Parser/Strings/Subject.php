<?php

namespace MemMemov\Cybe\Parser\Strings;

use MemMemov\Cybe\Parser\ISubject;

class Subject implements ISubject
{
    private $string;

    public function __construct(
        string $string
    ) {
        $this->string = $string;
    }
}