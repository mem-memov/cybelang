<?php

namespace MemMemov\Cybe;

class Arguments
{
    private static $type = 'argument';

    private $graph;
    private $categories;
    private $compliments;

    public function __construct(
        Graph $graph,
        Categories $categories,
        Compliments $compliments
    ) {
        $this->graph = $graph;
        $this->categories = $categories;
        $this->compliments = $compliments;
    }

    public function fromText(Parser\Argument $argumentText): Argument
    {
        $category = $this->categories->fromText($argumentText->category());
        $compliment = $this->compliments->fromText($argumentText->compliment());

        $argumentNode = $this->graph->createNode(self::$type, [$category->id(), $compliment->id()]);

        return new Argument(
            $argumentNode->id(),
            $this->categories,
            $this->compliments
        );
    }

    public function ofClause(Clause $clause): Arguments
    {
        $clauseNode = $this->graph->readNode($clause->id());

        $argumentNodes = $clauseNode->all(self::$type);

        return array_map(function(GraphNode $argumentNode) {
            return new Argument(
                $argumentNode->id(),
                $this->categories,
                $this->compliments
            );
        }, $argumentNodes);
    }
}