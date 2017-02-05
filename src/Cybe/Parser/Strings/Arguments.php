<?php

namespace MemMemov\Cybe\Parser\Strings;

use MemMemov\Cybe\Parser\IArgument;

class Arguments
{
    private $categories;
    private $compliments;

    public function __construct(
        Categories $categories,
        Compliments $compliments
    ) {
        $this->categories = $categories;
        $this->compliments = $compliments;
    }

    public function create(string $string): IArgument
    {
        return new Argument(
            $this->categories,
            $this->compliments,
            $string
        );
    }
}