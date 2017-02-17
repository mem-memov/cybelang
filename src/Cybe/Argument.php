<?php

namespace MemMemov\Cybe;

class Argument
{
    private $graphNode;
    private $categories;
    private $compliments;

    public function __construct(
        GraphNode $graphNode,
        Categories $categories,
        Compliments $compliments
    ) {
        $this->graphNode = $graphNode;
        $this->categories = $categories;
        $this->compliments = $compliments;
    }
}