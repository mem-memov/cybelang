<?php

namespace MemMemov\Cybe;

class Categories
{
    private static $graphSpace = 'category';

    private $graph;
    private $phrases;

    public function __construct(
        Graph $graph,
        Phrases $phrases
    ) {
        $this->graph = $graph;
        $this->phrases = $phrases;
    }

    public function fromText(Parser\Category $categoryText): Category
    {
        $phrase = $this->phrases->fromWords($categoryText->words());

        $categoryNode = $this->graph->сreateNode(self::$graphSpace, [$phrase->id()]);

        return new Category(
            $categoryNode->id(),
            $this->phrases
        );
    }
}