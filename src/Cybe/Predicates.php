<?php

namespace MemMemov\Cybe;

class Predicates
{
    private static $type = 'predicate';

    private $phrases;

    public function __construct(
        Phrases $phrases
    ) {
        $this->phrases = $phrases;
    }

    public function fromText(Parser\Predicate $predicateText): Predicate
    {
        $phrase = $this->phrases->fromWords($predicateText->getWords());

        return new Predicate($phrase);
    }

    public function ofClause(GraphNode $clauseNode)
    {
        $predicateNode = $clauseNode->oneOfType(self::$type);

        return new Predicate($predicateNode);
    }
}