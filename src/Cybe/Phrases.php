<?php

namespace MemMemov\Cybe;

class Phrases
{
    private static $graphSpace = 'phrase';

    private $graph;
    private $words;

    public function __construct(
        Graph $graph,
        Words $words
    ) {
        $this->graph = $graph;
        $this->words = $words;
    }

    public function fromWords(array $wordStrings): Phrase
    {
        $wordIds = array_map(function (string $letters) {
            return $this->words->fromLetters($letters)->id();
        }, $wordStrings);

        $phraseNode = $this->graph->сreateSequence(self::$graphSpace, $wordIds);

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