<?php

namespace MemMemov\Cybelang\Cybe;

use Psr\Log\LoggerInterface;

class Phrases implements Destructable
{
    private static $graphSpace = 'phrase';

    /** @var Graph */
    private $graph;
    /** @var Words */
    private $words;
    /** @var Subjects */
    private $subjects;
    /** @var Predicates */
    private $predicates;
    /** @var Arguments */
    private $arguments;
    /** @var LoggerInterface */
    private $logger;

    public function __construct(
        Graph $graph,
        Words $words,
        LoggerInterface $logger
    ) {
        $this->graph = $graph;
        $this->words = $words;
        $this->subjects = null;
        $this->predicates = null;
        $this->arguments = null;
        $this->logger = $logger;
    }
    
    public function destruct()
    {
        $this->graph = null;
        
        if (!is_null($this->words)) {
            $words = $this->words;
            $this->words = null;
            $words->destruct();
        }
        
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
    }
    
    public function setSubjects(Subjects $subjects)
    {
        if (!is_null($this->subjects)) {
            throw new ForbidCollectionRedefinition();
        }
        
        $this->subjects = $subjects;
    }
    
    public function setPredicates(Predicates $predicates)
    {
        if (!is_null($this->predicates)) {
            throw new ForbidCollectionRedefinition();
        }
        
        $this->predicates = $predicates;
    }
    
    public function setArguments(Arguments $arguments)
    {
        if (!is_null($this->arguments)) {
            throw new ForbidCollectionRedefinition();
        }
        
        $this->arguments = $arguments;
    }

    public function fromWords(array $wordStrings): Phrase
    {
        $wordIds = array_map(function (string $letters) {
            return $this->words->fromLetters($letters)->id();
        }, $wordStrings);

        $phraseNode = $this->graph->provideSequenceNode(self::$graphSpace, $wordIds);
        
        $this->logger->info('phrase provided', [$phraseNode->id(), $wordStrings]);

        return new Phrase(
            $phraseNode->id(),
            $this->words
        );
    }

    public function ofSubject(Subject $subject): Phrase
    {
        $subjectNode = $this->graph->readNode($subject->id());
        $phraseNode = $subjectNode->one(self::$graphSpace);

        return new Phrase(
            $phraseNode->id(),
            $this->words
        );
    }

    public function ofPredicate(Predicate $predicate): Phrase
    {
        $predicateNode = $this->graph->readNode($predicate->id());
        $phraseNode = $predicateNode->one(self::$graphSpace);

        return new Phrase(
            $phraseNode->id(),
            $this->words
        );
    }

    public function ofCategory(Category $category): Phrase
    {
        $categoryNode = $this->graph->readNode($category->id());
        $phraseNode = $categoryNode->one(self::$graphSpace);

        return new Phrase(
            $phraseNode->id(),
            $this->words
        );
    }

    public function ofCompliment(Compliment $compliment): Phrase
    {
        $complimentNode = $this->graph->readNode($compliment->id());
        $phraseNode = $complimentNode->one(self::$graphSpace);

        return new Phrase(
            $phraseNode->id(),
            $this->words
        );
    }
}