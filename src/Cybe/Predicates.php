<?php

namespace MemMemov\Cybe;

class Predicates
{
    private static $graphSpace = 'predicate';

    private $graph;
    private $arguments;
    private $phrases;

    public function __construct(
        Graph $graph,
        Arguments $arguments,
        Phrases $phrases
    ) {
        $this->graph = $graph;
        $this->arguments = $arguments;
        $this->phrases = $phrases;
    }

    public function fromText(Parser\Predicate $predicateText, Parser): Predicate
    {
        $this->arguments->fromText($predicateText->)

        $predicateNode = $this->graph->сreateNode(self::$graphSpace, );

        $phrase = $this->phrases->fromWords($predicateText->getWords());


        return new Predicate($phrase);
    }

    public function ofClause(Clause $clause): Predicate
    {
        $clauseNode = $this->graph->readNode($clause->id());
        $predicateNode = $clauseNode->one(self::$graphSpace);

        return new Predicate(
            $predicateNode->id(),
            $this->phrases
        );
    }
}