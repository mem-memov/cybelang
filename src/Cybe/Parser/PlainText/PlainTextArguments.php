<?php

namespace MemMemov\Cybe\Parser\PlainText;

use MemMemov\Cybe\Parser\Argument;

class PlainTextArguments
{
    private $categories;
    private $compliments;

    public function __construct(
        PlainTextCategories $categories,
        PlainTextCompliments $compliments
    ) {
        $this->categories = $categories;
        $this->compliments = $compliments;
    }

    public function create(string $string): Argument
    {
        return new PlainTextArgument(
            $this->categories,
            $this->compliments,
            $string
        );
    }
}