<?php

namespace MemMemov\Cybe;

class Clause
{
    private $predicate;
    private $subject;
    private $arguments;

    public function __construct(
        Predicate $predicate,
        Subject $subject,
        array $arguments
    ) {
        $this->predicate = $predicate;
        $this->subject = $subject;
        $this->arguments = $arguments;
    }
}