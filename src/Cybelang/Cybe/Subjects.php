<?php

namespace MemMemov\Cybelang\Cybe;

use Psr\Log\LoggerInterface;

class Subjects implements Destructable, Spaced
{
    private static $graphSpace = 'subject';

    /** @var Graph */
    private $graph;
    /** @var Phrases */
    private $phrases;
    /** @var Clauses */
    private $clauses;
    /** @var LoggerInterface */
    private $logger;

    public function __construct(
        Graph $graph,
        Phrases $phrases,
        LoggerInterface $logger
    ) {
        $this->graph = $graph;
        $this->phrases = $phrases;
        $this->clauses = null;
        $this->logger = $logger;
    }
    
    public function destruct()
    {
        $this->graph = null;
        
        if (!is_null($this->phrases)) {
            $phrases = $this->phrases;
            $this->phrases = null;
            $phrases->destruct();
        }
        
        if (!is_null($this->clauses)) {
            $clauses = $this->clauses;
            $this->clauses = null;
            $clauses->destruct();
        }
    }
    
    public function setClauses(Clauses $clauses)
    {
        if (!is_null($this->clauses)) {
            throw new ForbidCollectionRedefinition();
        }
        
        $this->clauses = $clauses;
    }
    
    public function graphSpace(): string
    {
        return self::$graphSpace;
    }

    public function fromText(Parser\Subject $subjectText): Subject
    {
        $phrase = $this->phrases->fromWords($subjectText->words());
        $subjectNode = $this->graph->provideCommonNode(self::$graphSpace, [$phrase->id()]);
        
        $this->logger->info('subject provided', [$subjectNode->id(), $subjectText->text()]);

        return new Subject(
            $subjectNode->id(),
            $this->phrases
        );
    }

    public function ofClause(Clause $clause): Subject
    {
        $clauseNode = $this->graph->readNode($this->clauses->graphSpace(), $clause->id());
        $subjectNode = $clauseNode->one(self::$graphSpace);

        return new Subject(
            $subjectNode->id(),
            $this->phrases
        );
    }
}