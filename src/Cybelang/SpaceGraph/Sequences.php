<?php

namespace MemMemov\Cybelang\SpaceGraph;

class Sequences
{
    private $nodes;
    private $spaces;

    public function __construct(
        Nodes $nodes,
        Spaces $spaces
    ) {
        $this->nodes = $nodes;
        $this->spaces = $spaces;
    }

    /**
     * @param string $spaceName
     * @param int[] $ids
     * @return SpaceNode
     */
    public function provideSequenceNode(string $spaceName, array $ids): Node
    {
        $space = $this->spaces->provideSpace($spaceName);

        $nodes = [];
        foreach ($ids as $id) {
            $nodes[] = $this->nodes->read($id);
        }

        if (!$this->spaces->inSameSpace($nodes)) {
            throw new ForbidSequencingMultipleSpaces();
        }

        $lastNode = array_reduce(
            $nodes,
            function(Node $lastNode = null, Node $node) use ($space) {
                return is_null($lastNode)
                    ? $space->createCommonNode($node)
                    : $space->createCommonNode([$lastNode, $node]);
            }
        );

        return $lastNode;
    }

    /**
     * @param string $spaceName
     * @param int $id
     * @return SpaceNode[]
     */
    public function readNodeSequence(string $spaceName, int $id): array
    {
        $space = $this->spaces->provideSpace($spaceName);
        $lastNode = $this->nodes->read($id);
        $lastNodeSpace = $this->spaces->spaceOfNode($lastNode);

        $node = $space->getOneNode($lastNode);

        $previousNodes = $lastNodeSpace->findNodes($lastNode);
        $previousNodeCount = count($previousNodes);

        if (0 === $previousNodeCount) {
            return [$node];
        }

        if (1 === $previousNodeCount) {
            $previousNode = $previousNodes[0];
            $sequence = $this->readNodeSequence($spaceName, $previousNode->id());
            $sequence[] = $node;
            return $sequence;
        }
    }
}