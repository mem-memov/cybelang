<?php

namespace MemMemov\Cybelang\Cybe;

use Psr\Log\LoggerInterface;

class Arguments implements Destructable, Spaced
{
    private static $graphSpace = 'argument';

    /** @var Graph */
    private $graph;
    /** @var Categories */
    private $categories;
    /** @var Compliments */
    private $compliments;
    /** @var Clauses */
    private $clauses;
    /** @var LoggerInterface */
    private $logger;

    public function __construct(
        Graph $graph,
        Categories $categories,
        Compliments $compliments,
        LoggerInterface $logger
    ) {
        $this->graph = $graph;
        $this->categories = $categories;
        $this->compliments = $compliments;
        $this->clauses = null;
        $this->logger = $logger;
    }
    
    public function destruct()
    {
        $this->graph = null;
        
        if (!is_null($this->categories)) {
            $categories = $this->categories;
            $this->categories = null;
            $categories->destruct();
        }
        
        if (!is_null($this->compliments)) {
            $compliments = $this->compliments;
            $this->compliments = null;
            $compliments->destruct();
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

    public function fromText(Parser\Argument $argumentText): Argument
    {
        $category = $this->categories->fromText($argumentText->category());
        $compliment = $this->compliments->fromText($argumentText->compliment());

        $argumentNode = $this->graph->provideCommonNode(self::$graphSpace, [$category->id(), $compliment->id()]);

        $this->logger->info('argument provided', [$argumentNode->id(), $argumentText->text()]);
        
        return new Argument(
            $argumentNode->id(),
            $this->categories,
            $this->compliments
        );
    }

    /**
     * @param Clause $clause
     * @return Argument[]
     */
    public function ofClause(Clause $clause): array
    {
        $clauseNode = $this->graph->readNode($this->clauses->graphSpace(), $clause->id());

        $arguments = [];
        $argumentNodes = $clauseNode->all(self::$graphSpace);
        
        foreach ($argumentNodes as $argumentNode) {
            $arguments[] = new Argument(
                $argumentNode->id(),
                $this->categories,
                $this->compliments
            );
        }

        return $arguments;
    }
    
    public function search(Parser\Argument $argumentText): array
    {
        $categories = $this->categories->search($argumentText->category());
        $compliments = $this->compliments->search($argumentText->compliment());
    }
}