<?php

namespace MemMemov\Cybe;

class Argument
{
    private $category;
    private $compliment;

    public function __construct(
        Category $category,
        Compliment $compliment
    ) {
        $this->category = $category;
        $this->compliment = $compliment;
    }
}