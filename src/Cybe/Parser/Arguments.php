<?php

namespace MemMemov\Cybe\Parser;

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

    public function create(string $string): Argument
    {
        return new Argument(
            $this->categories,
            $this->compliments,
            $string
        );
    }
}