<?php

namespace MemMemov\Cybelang\Cybe;

use Psr\Log\LoggerInterface;

class Messages implements Destructable, Spaced
{
    private static $graphSpace = 'message';
    
    /** @var Graph */
    private $graph;
    /** @var Clauses */
    private $clauses;
    /** @var Contexts */
    private $contexts;
    /** @var Statements */
    private $statements;
    /** @var Utterances */
    private $utterances;
    /** @var LoggerInterface */
    private $logger;

    public function __construct(
        Graph $graph,
        Clauses $clauses,
        LoggerInterface $logger
    ) {
        $this->graph = $graph;
        $this->clauses = $clauses;
        $this->contexts = null;
        $this->statements = null;
        $this->utterances = null;
        $this->logger = $logger;
    }
    
    public function destruct()
    {
        $this->graph = null;
        
        if (!is_null($this->clauses)) {
            $clauses = $this->clauses;
            $this->clauses = null;
            $clauses->destruct();
        }
        
        if (!is_null($this->contexts)) {
            $contexts = $this->contexts;
            $this->contexts = null;
            $contexts->destruct();
        }
        
        if (!is_null($this->statements)) {
            $statements = $this->statements;
            $this->statements = null;
            $statements->destruct();
        }
        
        if (!is_null($this->utterances)) {
            $utterances = $this->utterances;
            $this->utterances = null;
            $utterances->destruct();
        }
    }
    
    public function setContexts(Contexts $contexts)
    {
        if (!is_null($this->contexts)) {
            throw new ForbidCollectionRedefinition();
        }
        
        $this->contexts = $contexts;
    }
    
    public function setStatements(Statements $statements)
    {
        if (!is_null($this->statements)) {
            throw new ForbidCollectionRedefinition();
        }
        
        $this->statements = $statements;
    }
    
    public function setUtterances(Utterances $utterances)
    {
        if (!is_null($this->utterances)) {
            throw new ForbidCollectionRedefinition();
        }
        
        $this->utterances = $utterances;
    }
    
    public function graphSpace(): string
    {
        return self::$graphSpace;
    }

    /**
     * 
     * @param Parser\Message $messageText
     * @param Message[] $contexrMessages
     * @return Message
     */
    public function fromText(Parser\Message $messageText, array $contextMessages): Message
    {
        $clauseIds = [];
        foreach ($messageText->clauses() as $clauseText) {
            $clause = $this->clauses->fromText($clauseText);
            $clauseIds[] = $clause->id();
        }
        
        if (0 !== count($contextMessages)) {
            $context = $this->contexts->create($contextMessages);
            $statement = $this->statements->create($context);
            $statementId = $statement->id();
            $connections = array_merge($clauseIds, [$statementId]);
            $messageNode = $this->graph->createNode(self::$graphSpace, $connections, $connections);
            $this->logger->info('message created in context', ['id' => $messageNodeId, 'context' => $context->id(), 'statement' => $statementId, 'text' => $messageText->text()]);
        } else {
            $messageNode = $this->graph->createNode(self::$graphSpace, $clauseIds, $clauseIds);
            $this->logger->info('message created', ['id' => $messageNodeId, 'text' => $messageText->text()]);
        }

        $messageNodeId = $messageNode->id();

        return new Message(
            $messageNodeId,
            $this->utterances,
            $this->clauses,
            $this->contexts,
            $this->statements
        );
    }
    
    public function ofUtterance(Utterance $utterance): Message
    {
        $messageNodes = $this->graph->filterNode(self::$graphSpace, $utterance->id());
       
        if (count($messageNodes) > 1) {
            throw new \Exception('An utterance must have only one message.');
        }
        
        if (count($messageNodes) === 0) {
            throw new \Exception('An utterance must have only one message.');
        }
        
        $messageNode = array_pop($messageNodes);
        
        return new Message(
            $messageNode->id(),
            $this->utterances,
            $this->clauses,
            $this->contexts,
            $this->statements
        );
    }
    
    public function search(Parser\Message $messageText): array
    {
        foreach ($messageText->clauses() as $clauseText) {
            $this->clauses->search($clauseText);
        }
    }
}