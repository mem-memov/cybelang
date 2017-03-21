<?php

namespace MemMemov\Cybelang\Cybe;

use Psr\Log\LoggerInterface;

class Predicates implements Destructable, Spaced
{
    private static $graphSpace = 'predicate';

    /** @var Graph */
    private $graph;
    /** @var Arguments */
    private $arguments;
    /** @var Phrases */
    private $phrases;
    /** @var Clauses */
    private $clauses;
    /** @var LoggerInterface */
    private $logger;

    public function __construct(
        Graph $graph,
        Arguments $arguments,
        Phrases $phrases,
        LoggerInterface $logger
    ) {
        $this->graph = $graph;
        $this->arguments = $arguments;
        $this->phrases = $phrases;
        $this->clauses = null;
        $this->logger = $logger;
    }
    
    public function destruct()
    {
        $this->graph = null;
        
        if (!is_null($this->arguments)) {
            $arguments = $this->arguments;
            $this->arguments = null;
            $arguments->destruct();
        }
        
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

    public function fromText(Parser\Predicate $predicateText): Predicate
    {
        $phrase = $this->phrases->fromWords($predicateText->words());
        $predicateNode = $this->graph->provideCommonNode(self::$graphSpace, [$phrase->id()]);
        
        $this->logger->info('predicate provided', [$predicateNode->id(), $predicateText->text()]);

        return new Predicate(
            $predicateNode->id(),
            $this->phrases
        );
    }

    public function ofClause(Clause $clause): Predicate
    {
        $clauseNode = $this->graph->readNode($this->clauses->graphSpace(), $clause->id());
        $predicateNode = $clauseNode->one(self::$graphSpace);

        return new Predicate(
            $predicateNode->id(),
            $this->phrases
        );
    }
    
    public function search(Parser\Predicate $predicateText): array
    {
        return $this->phrases->search($predicateText->words());
    }
}