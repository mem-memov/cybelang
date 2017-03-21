<?php

namespace MemMemov\Cybelang\Cybe;

class Author
{
    private $id;
    private $messages;
    private $utterances;
    private $parser;

    public function __construct(
        int $id,
        Messages $messages,
        Utterances $utterances,
        Parser\Messages $parser
    ) {
        $this->id = $id;
        $this->messages = $messages;
        $this->utterances = $utterances;
        $this->parser = $parser;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function write(string $text, array $utteranceIds): int
    {
        $messageText = $this->parser->create($text);
        
        $contextMessages = [];
        foreach ($utteranceIds as $utteranceId) {
            $utterance = $this->utterances->getUtterance($utteranceId);
            $contextMessages[] = $utterance->message();
        }
        
        $message = $this->messages->fromText($messageText, $contextMessages);

        $utterance = $this->utterances->create($message, $this);
        
        return $utterance->id();
    }
    
    public function recall(int $limit): string
    {
        $utterances = $this->utterances->ofAuthor($this, $limit);
       
        $text = '';
        foreach ($utterances as $utterance) {
            $message = $utterance->message();
            $text .= $message->toText();
        }
        
        return $text;
    }    
    
    /**
     * 
     * @param string $query
     * @return Uttering[]
     */
    public function search(string $query): array
    {
        $messageText = $this->parser->create($text);
        
        
    }
}
