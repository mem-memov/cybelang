<?php

namespace MemMemov\Cybelang\Cybe;

class Arguments implements Destructable
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

    public function __construct(
        Graph $graph,
        Categories $categories,
        Compliments $compliments
    ) {
        $this->graph = $graph;
        $this->categories = $categories;
        $this->compliments = $compliments;
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
     * @param Clause $clause
     * @return Argument[]
     */
    public function ofClause(Clause $clause): array
    {
        $clauseNode = $this->graph->readNode($clause->id());

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
}