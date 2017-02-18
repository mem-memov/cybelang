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
        $space = $this->spaces->provideSpace($type);

        $nodes = array_map(function(int $id) {
            return $this->graph->readNode($id);
        }, $ids);

        $commonNodes = $this->graph->intersect($nodes);

        $commonNodeCount = count($commonNodes);

        if (1 === $commonNodeCount) {
            $commonNode = $commonNodes[0];
        } elseif (0 === $commonNodeCount) {
            $commonNode = $this->graph->createNode();
            $space->add($commonNode);
            array_map(function(Node $node) use ($commonNode) {
                $commonNode->addNode($node);
                $node->addNode($commonNode);
            }, $nodes);
        } else {
            throw new \Exception('Multiple common nodes detected');
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