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
        $argumentNode = $this->graph->readOrCreateNode(self::$type, []);

        $argument = new Argument(
            $argumentNode,
            $this->categories,
            $this->compliments
        );

        $this->categories->fromText($argument, $argumentText->category());
        $this->compliments->fromText($argument, $argumentText->compliment());

        return $argument;
    }

    public function ofClause(GraphNode $clauseNode): Arguments
    {
        $argumentNodes = $clauseNode->allOfType(self::$type);

        return new ClauseArguments($argumentNodes);
    }
}