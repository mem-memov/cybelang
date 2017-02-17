<?php

namespace MemMemov\Cybe;

use MemMemov\GraphStore\GraphValue;

class Word
{
    private $graphValue;

    public function __construct(
        GraphValue $graphValue
    ) {
        $this->graphValue = $graphValue;
    }

    public function id(): int
    {
        return $this->graphValue->id();
    }
}