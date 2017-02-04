<?php

namespace MemMemov\Cybe\Strings;

class Arguments
{
    private $categories;
    private $compliments;

    public function __construct(
        Categories $categories,
        Compliments $compliments,
        string $string
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