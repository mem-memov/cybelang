<?php

namespace MemMemov\Cybelang\Cybe;

class Subjects
{
    private static $graphSpace = 'subject';

    private $graph;
    private $phrases;

    public function __construct(
        Graph $graph,
        Phrases $phrases
    ) {
        $this->graph = $graph;
        $this->phrases = $phrases;
    }

    public function fromText(Parser\Subject $subjectText): Subject
    {
        $phrase = $this->phrases->fromWords($subjectText->getWords());
        $subjectNode = $this->graph->сreateNode(self::$graphSpace, [$phrase->id()]);

        return new Subject(
            $subjectNode->id(),
            $this->phrases
        );
    }

    public function ofClause(Clause $clause): Subject
    {
        $clauseNode = $this->graph->readNode($clause->id());
        $subjectNode = $clauseNode->one(self::$graphSpace);

        return new Subject(
            $subjectNode->id(),
            $this->phrases
        );
    }
}