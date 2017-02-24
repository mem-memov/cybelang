<?php

namespace MemMemov\Cybe\Parser\PlainText;

use MemMemov\Cybe\Parser\Category;

class PlainTextCategory implements Category
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