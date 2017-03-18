<?php

namespace MemMemov\Cybelang\Cybe\Parser\PlainText;

use MemMemov\Cybelang\Cybe\Parser\Predicate;

class PlainTextPredicate implements Predicate
{
    private $string;

    public function __construct(string $string)
    {
        $this->string = $string;
    }
    
    public function text(): string
    {
        return $this->string;
    }

    /**
     * @return string[]
     */
    public function words(): array
    {
        return explode(' ', $this->string);
    }
}