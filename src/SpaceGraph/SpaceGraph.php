<?php

namespace MemMemov\SpaceGraph;

use MemMemov\Cybe\Graph;
use MemMemov\Cybe\GraphNode;
use MemMemov\Cybe\GraphSequence;
use MemMemov\Cybe\GraphValue;

class SpaceGraph implements Graph
{
    private $nodes;
    private $spaces;
    private $spaceNodes;
    private $store;

    public function __construct(
        Nodes $nodes,
        Spaces $spaces,
        SpaceNodes $spaceNodes,
        Store $store
    ) {
        $this->nodes = $nodes;
        $this->spaces = $spaces;
        $this->spaceNodes = $spaceNodes;
        $this->store = $store;
    }

    public function provideForValue(string $type, string $value): SpaceNode
    {
        $id = $this->store->provideNode($value);
        
        return $this->spaceNodes->read($id);
    }

    public function provideCommonNode(string $type, array $ids): SpaceNode
    {
        $space = $this->spaces->provideSpace($type);

        $idCount = count($ids);
        $commonIds = array_filter(
            $this->store->intersect($ids),
            function(int $commonId) use ($idCount) {
                return $this->store->countNode($commonId) === $idCount;
            }
        );

        $commonIdCount = count($commonIds);

        if (0 === $commonIdCount) {
            $commonId = $this->store->createNode();
            //$space->add($commonNode);
            array_map(function(Node $node) use ($commonNode) {
                $commonNode->addNode($node);
                $node->addNode($commonNode);
            }, $nodes);
        } elseif () {
            $idCount = count($ids);
            $countedCommonIds = [];
            foreach ($commonIds as $commonId) {
                if ($this->store->countNode($commonId) === $idCount) {
                    $countedCommonIds[] = $commonId;
                }
            }
            if () {

            }
            throw new \Exception('Multiple common nodes detected');
        }

        return new SpaceNode($commonId, $type, $this->graph, $this->spaces);
    }

    public function readNode(int $id): GraphNode
    {

    }

    public function сreateSequence(string $type, array $ids): GraphSequence
    {

    }

    public function readSequence(int $id): GraphSequence
    {

    }

    public function сreateValue(string $type, string $content): GraphValue
    {

    }

    public function readValue(int $id): GraphValue
    {

    }
}