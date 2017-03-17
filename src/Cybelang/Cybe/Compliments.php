<?php

namespace MemMemov\Cybelang\Cybe;

class Compliments implements Destructable
{
    private static $graphSpace = 'compliment';

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

    public function fromText(Parser\Compliment $complimentText): Compliment
    {
        $phrase = $this->phrases->fromWords($complimentText->words());
        $complimentNode = $this->graph->provideCommonNode(self::$graphSpace, [$phrase->id()]);

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