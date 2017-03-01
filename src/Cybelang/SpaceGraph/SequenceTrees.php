<?php

namespace MemMemov\Cybelang\SpaceGraph;

class SequenceTrees
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
     * @param Node[] $sequenceNodes
     * @return SequenceTree
     */
    public function create(string $treeSpaceName, array $sequenceNodes): SequenceTree
    {
        $sequenceNode = array_pop($sequenceNodes);

        $treeSpace = $this->spaces->provideSpace($treeSpaceName);

        if (0 === count($sequenceNodes)) {
            $treeNode = $treeSpace->createCommonNode([$sequenceNode]);
        } else {
            $previousTree = $this->create($treeSpaceName, $sequenceNodes);
            $treeNode = $treeSpace->createCommonNode([$previousTree->getTreeNode(), $sequenceNode]);
        }

        return new SequenceTree($treeNode, $sequenceNode, $this->nodes, $this->spaces);
    }

    public function get(string $sequenceSpaceName, int $treeNodeId): SequenceTree
    {
        $treeNode = $this->nodes->read($treeNodeId);

        $sequenceSpace = $this->spaces->provideSpace($sequenceSpaceName);
        $sequenceNode = $sequenceSpace->getOneNode($treeNode);

        return new SequenceTree($treeNode, $sequenceNode, $this->nodes, $this->spaces);
    }
}