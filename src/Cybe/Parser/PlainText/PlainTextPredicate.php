<?php

namespace MemMemov\Cybe\Parser\PlainText;

use MemMemov\Cybe\Parser\Predicate;

class PlainTextPredicate implements Predicate
{
    private $string;

    public function __construct(string $string)
    {
        $this->string = $string;
    }

    /**
     * @return string[]
     */
    public function words(): array
    {
        return explode(' ', $this->string);
    }
}