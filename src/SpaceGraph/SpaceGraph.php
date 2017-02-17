<?php

namespace MemMemov\SpaceGraph;

use MemMemov\Cybe\Graph as CybeGraph;
use MemMemov\Cybe\GraphNode;
use MemMemov\Cybe\GraphSequence;
use MemMemov\Cybe\GraphValue;

class SpaceGraph implements CybeGraph
{
    private $graph;
    private $spaces;

    public function __construct(
        Graph $graph,
        Spaces $spaces
    ) {
        $this->graph = $graph;
        $this->spaces = $spaces;
    }

    public function сreateCommonNode(string $type, array $ids): SpaceNode
    {
        $space = $this->spaces->createSpace($type);

        $nodes = array_map(function(int $id) {
            return $this->graph->readNode($id);
        }, $ids);

        $commonNodes = $this->graph->intersect($nodes);

        if (1 === count($commonNodes)) {
            $commonNode = $commonNodes[0];
        } else {
            $commonNode = $this->graph->createNode();
            $space->add($commonNode);
            array_map(function(Node $node) use ($commonNode) {
                $commonNode->addNode($node);
                $node->addNode($commonNode);
            }, $nodes);
        }

        return new SpaceNode($commonNode, $this->spaces);
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