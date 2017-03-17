<?php

namespace MemMemov\Cybelang\SpaceGraph\Sequence;

use MemMemov\Cybelang\SpaceGraph\Node\Node;
use MemMemov\Cybelang\SpaceGraph\Node\Nodes;

class Sequences
{
    private $nodes;
    private $sequenceTrees;

    public function __construct(
        Nodes $nodes,
        SequenceTrees $sequenceTrees
    ) {
        $this->nodes = $nodes;
        $this->sequenceTrees = $sequenceTrees;
    }

    /**
     * @param string $spaceName
     * @param int[] $ids
     * @return SpaceNode
     */
    public function provideSequenceNode(string $treeSpaceName, array $ids): Node
    {
        $nodes = [];
        foreach ($ids as $id) {
            $nodes[] = $this->nodes->read($id);
        }

        $sequenceTree = $this->sequenceTrees->create($treeSpaceName, $nodes);

        return $sequenceTree->getTreeNode();
    }

    /**
     * @param string $spaceName
     * @param int $id
     * @return Node[]
     */
    public function readNodeSequence(string $sequenceSpaceName, int $treeNodeId): array
    {
        $sequenceTree = $this->sequenceTrees->get($sequenceSpaceName, $treeNodeId);

        return $sequenceTree->collectSequenceNodes();
    }
}