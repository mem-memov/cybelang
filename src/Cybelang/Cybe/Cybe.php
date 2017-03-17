<?php

namespace MemMemov\Cybelang\Cybe;

class Cybe implements Destructable
{
    private $authors;
    
    public function __construct(Authors $authors)
    {
        $this->authors = $authors;
    }

    public function destruct()
    {
        $this->authors->destruct();
        $this->authors = null;
    }
    
    public function createAuthor(): Author
    {
        return $this->authors->createAuthor();
    }
    
    public function getAuthor(): Author
    {
        
    }
}