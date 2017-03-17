<?php

namespace MemMemov\Cybelang\Cybe;

class Categories implements Destructable
{
    private static $graphSpace = 'category';

    /** @var Graph */
    private $graph;
    /** @var Phrases */
    private $phrases;
    /** @var Arguments */
    private $arguments;

    public function __construct(
        Graph $graph,
        Phrases $phrases
    ) {
        $this->graph = $graph;
        $this->phrases = $phrases;
    }
    
    public function destruct()
    {
        $this->graph = null;
        
        if (!is_null($this->phrases)) {
            $phrases = $this->phrases;
            $this->phrases = null;
            $phrases->destruct();
        }
        
        if (!is_null($this->arguments)) {
            $arguments = $this->arguments;
            $this->arguments = null;
            $arguments->destruct();
        }
    }
    
    public function setArguments(Arguments $arguments)
    {
        if (!is_null($this->arguments)) {
            throw new ForbidCollectionRedefinition();
        }
        
        $this->arguments = $arguments;
    }

    public function fromText(Parser\Category $categoryText): Category
    {
        $phrase = $this->phrases->fromWords($categoryText->words());
        $categoryNode = $this->graph->provideCommonNode(self::$graphSpace, [$phrase->id()]);

        return new Category(
            $categoryNode->id(),
            $this->phrases
        );
    }

    public function ofArgument(Argument $argument): Category
    {
        $argumentNode = $this->graph->readNode($argument->id());
        $categoryNode = $argumentNode->one(self::$graphSpace);

        return new Category(
            $categoryNode->id(),
            $this->phrases
        );
    }
}