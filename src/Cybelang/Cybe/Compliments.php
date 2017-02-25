<?php

namespace MemMemov\Cybelang\Cybe;

class Compliments
{
    private static $graphSpace = 'compliment';

    private $graph;
    private $phrases;

    public function __construct(
        Graph $graph,
        Phrases $phrases
    ) {
        $this->graph = $graph;
        $this->phrases = $phrases;
    }

    public function fromText(Parser\Compliment $complimentText): Compliment
    {
        $phrase = $this->phrases->fromWords($complimentText->words());
        $complimentNode = $this->graph->сreateNode(self::$graphSpace, [$phrase->id()]);

        return new Compliment(
            $complimentNode->id(),
            $this->phrases
        );
    }

    public function ofArgument(Argument $argument): Compliment
    {
        $argumentNode = $this->graph->readNode($argument->id());
        $complimentNode = $argumentNode->one(self::$graphSpace);

        return new Compliment(
            $complimentNode->id(),
            $this->phrases
        );
    }
}