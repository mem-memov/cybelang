<?php

namespace MemMemov\Cybelang\Cybe;

class Cybes
{
    public function create(Graph $graph, Parser\Messages $parser): Cybe
    {
        $words = new Words($graph);
        $phrases = new Phrases($graph, $words);
        $subjects = new Subjects($graph, $phrases);
        $categories = new Categories($graph, $phrases);
        $compliments = new Compliments($graph, $phrases);
        $arguments = new Arguments($graph, $categories, $compliments);
        $predicates = new Predicates($graph, $arguments, $phrases);
        $clauses = new Clauses($graph, $subjects, $predicates, $arguments);
        $messages = new Messages($graph, $clauses);
        $contexts = new Contexts($graph, $messages);
        $statements = new Statements($graph, $messages);
        $utterances = new Utterances($graph, $messages);
        $authors = new Authors($graph, $messages, $utterances, $parser);
        
        $words->setPhrases($phrases);
        $phrases->setSubjects($subjects);
        $phrases->setPredicates($predicates);
        $phrases->setArguments($arguments);
        $subjects->setClauses($clauses);
        $predicates->setClauses($clauses);
        $arguments->setClauses($clauses);
        $categories->setArguments($arguments);
        $compliments->setArguments($arguments);
        $clauses->setMessages($messages);
        $messages->setContexts($contexts);
        $messages->setStatements($statements);
        $messages->setUtterances($utterances);
        $contexts->setStatements($statements);
        $statements->setContexts($contexts);
        $utterances->setAuthors($authors);
        
        return new Cybe($authors);
    }
}
