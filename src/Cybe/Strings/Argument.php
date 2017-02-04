<?php

namespace MemMemov\Cybe\Strings;

class Argument
{
    private $string;

    public function __construct(
        string $string
    ) {
        $this->string = $string;
    }
}