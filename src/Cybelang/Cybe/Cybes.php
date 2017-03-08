<?php

namespace MemMemov\Cybelang\Cybe;

class Cybes
{
    public function create(Graph $graph): Cybe
    {
        $words = new Words($graph);
        
        $phrases = new Phrases($graph, $words);
        
        $subjects = new Subjects($graph, $phrases);
        
        $categories = new Categories($graph, $phrases);
        
        $compliments = new Compliments($graph, $phrases);
        
        $arguments = new Arguments($graph, $categories, $compliments);
        
        $predicates = new Predicates($graph, $arguments, $phrases);

        $clauses = new Clauses($graph, $subjects, $predicates, $arguments);
        
        return new Cybe();
    }
}
