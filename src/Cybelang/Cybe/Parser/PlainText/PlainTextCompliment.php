<?php

namespace MemMemov\Cybelang\Cybe\Parser\PlainText;

use MemMemov\Cybelang\Cybe\Parser\Compliment;

class PlainTextCompliment implements Compliment
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