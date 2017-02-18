<?php

namespace MemMemov\SpaceGraph;

use MemMemov\Cybe\SpaceGraph;

class Spaces implements SpaceGraph
{
    private $store;
    private $root;

    public function __construct(
        Store $store,
        string $rootKey
    ) {
        $this->store = $store;
        $this->root = $this->store->readOrCreateValue($rootKey);
    }

    public function provideSpace(string $name): Space
    {
        $value = $this->store->provideNode($name);
        $this->root->addNode($value);

        return new Space(
            $value,
            $this->graph
        );
    }
}