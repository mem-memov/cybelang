<?php

namespace MemMemov\Cybe;

use MemMemov\GraphStore\GraphValue;

class Word
{
    private $graphValue;

    public function __construct(
        GraphValue $graphValue
    ) {
        $graphValue = $graphValue;
    }

    public function getId(): int
    {
        return $graphValue->id();
    }
}