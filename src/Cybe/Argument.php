<?php

namespace MemMemov\Cybe;

class Argument
{
    private $id;
    private $categories;
    private $compliments;

    public function __construct(
        int $id,
        Categories $categories,
        Compliments $compliments
    ) {
        $this->id = $id;
        $this->categories = $categories;
        $this->compliments = $compliments;
    }

    public function category(): Category
    {
        return $this->categories->ofArgument($this);
    }

    public function compliment(): Compliment
    {
        return $this->compliments->ofArgument($this);
    }
}