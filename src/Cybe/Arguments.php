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

    public function ofPredicate(Predicate $predicate): Arguments
    {
        $predicateNode = $this->graph->readNode($predicate->id());

        $arguments = [];

        $predicateNode->all(self::$type, function(GraphNode $argumentNode) use ($arguments) {
            $arguments[] = new Argument(
                $argumentNode->id(),
                $this->categories,
                $this->compliments
            );
        });

        return $arguments;
    }
}