<?php

namespace MemMemov\Cybelang\Cybe;

use Psr\Log\LoggerInterface;

class Clauses implements Destructable, Spaced
{
    private static $graphSpace = 'clause';

    /** @var Graph */
    private $graph;
    /** @var Subjects */
    private $subjects;
    /** @var Predicates */
    private $predicates;
    /** @var Arguments */
    private $arguments;
    /** @var Messages */
    private $messages;
    /** @var LoggerInterface */
    private $logger;

    public function __construct(
        Graph $graph,
        Subjects $subjects,
        Predicates $predicates,
        Arguments $arguments,
        LoggerInterface $logger
    ) {
        $this->graph = $graph;
        $this->subjects = $subjects;
        $this->predicates = $predicates;
        $this->arguments = $arguments;
        $this->messages = null;
        $this->logger = $logger;
    }
    
    public function destruct()
    {
        $this->graph = null;
        
        if (!is_null($this->subjects)) {
            $subjects = $this->subjects;
            $this->subjects = null;
            $subjects->destruct();
        }
        
        if (!is_null($this->predicates)) {
            $predicates = $this->predicates;
            $this->predicates = null;
            $predicates->destruct();
        }
        
        if (!is_null($this->arguments)) {
            $arguments = $this->arguments;
            $this->arguments = null;
            $arguments->destruct();
        }
        
        if (!is_null($this->messages)) {
            $messages = $this->messages;
            $this->messages = null;
            $messages->destruct();
        }
    }
    
    public function setMessages(Messages $messages)
    {
        if (!is_null($this->messages)) {
            throw new ForbidCollectionRedefinition();
        }
        
        $this->messages = $messages;
    }
    
    public function graphSpace(): string
    {
        return self::$graphSpace;
    }

    public function fromText(Parser\Clause $clauseText): Clause
    {
        $subject = $this->subjects->fromText($clauseText->subject());
        $predicate = $this->predicates->fromText($clauseText->predicate());

        $argumentIds = array_map(function(Parser\Argument $argumentText) {
            $argument = $this->arguments->fromText($argumentText);
            return $argument->id();
        }, $clauseText->arguments());

        $memberIds = array_merge([$subject->id(), $predicate->id()], $argumentIds);

        $clauseNode = $this->graph->provideCommonNode(self::$graphSpace, $memberIds);
        
        $this->logger->info('clause provided', [$clauseNode->id(), $clauseText->text()]);

        return new Clause(
            $clauseNode->id(),
            $this->subjects,
            $this->predicates,
            $this->arguments
        );
    }
    
    public function ofMessage(Message $message): array
    {
        $closeNodes = $this->graph->filterNode(self::$graphSpace, $message->id());
        
        $clauses = [];
        foreach ($closeNodes as $clauseNode) {
            $clauses[] = new Clause(
                $clauseNode->id(),
                $this->subjects,
                $this->predicates,
                $this->arguments
            );
        }
        
        return $clauses;
    }
    
    public function search(Parser\Clause $clauseText): array
    {
        $subjects = $this->subjects->search($clauseText->subject());
        $predicates = $this->predicates->search($clauseText->predicate());
        
        $arguments = [];
        foreach ($clauseText->arguments() as $argumentText) {
            $arguments[] = $this->arguments->search($argumentText);
        }
    }
}