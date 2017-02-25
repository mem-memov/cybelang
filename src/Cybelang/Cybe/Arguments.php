<?php

namespace MemMemov\Cybelang\Cybe;

class Arguments
{
    private static $graphSpace = 'argument';

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

        $argumentNode = $this->graph->provideCommonNode(self::$graphSpace, [$category->id(), $compliment->id()]);

        return new Argument(
            $argumentNode->id(),
            $this->categories,
            $this->compliments
        );
    }

    /**
     * @param Predicate $predicate
     * @return Argument[]
     */
    public function ofPredicate(Predicate $predicate): array
    {
        $predicateNode = $this->graph->readNode($predicate->id());

        $arguments = [];

        $predicateNode->all(self::$graphSpace, function(GraphNode $argumentNode) use ($arguments) {
            $arguments[] = new Argument(
                $argumentNode->id(),
                $this->categories,
                $this->compliments
            );
        });

        return $arguments;
    }
}