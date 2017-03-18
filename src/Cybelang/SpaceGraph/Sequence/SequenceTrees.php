<?php

namespace MemMemov\Cybelang\SpaceGraph\Sequence;

use MemMemov\Cybelang\SpaceGraph\Node\Nodes;
use MemMemov\Cybelang\SpaceGraph\Space\Spaces;

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
        if (0 === count($sequenceNodes)) {
            throw new ForbidEmptySequence();
        }
        
        $treeSpace = $this->spaces->provideSpace($treeSpaceName);
        $sequenceTrees = [];
        
        /** @var Node $sequenceNode */
        foreach ($sequenceNodes as $index => $sequenceNode) {
            
            $treeNodes = $treeSpace->findNodes($sequenceNode);
            $treeNodeCount = count($treeNodes);
            
            if (1 === $treeNodeCount) { // read
                $treeNode = array_pop($treeNodes);
            }
            
            if (0 === $treeNodeCount) { // create
                if (0 === $index) {
                    $treeNode = $treeSpace->createCommonNode([$sequenceNode]);
                } else {
                    $previousTree = $sequenceTrees[$index - 1];
                    $treeNode = $treeSpace->createCommonNode([$previousTree->getTreeNode(), $sequenceNode]);
                }
            }
            
            if (1 < $treeNodeCount) {
                throw new \Exception();
            }

            $sequenceTrees[] = new SequenceTree($treeNode, $sequenceNode, $this->nodes, $this->spaces);
        }
        
        return end($sequenceTrees);
    }

    public function get(string $sequenceSpaceName, int $treeNodeId): SequenceTree
    {
        $treeNode = $this->nodes->read($treeNodeId);

        $sequenceSpace = $this->spaces->provideSpace($sequenceSpaceName);
        $sequenceNode = $sequenceSpace->getOneNode($treeNode);

        return new SequenceTree($treeNode, $sequenceNode, $this->nodes, $this->spaces);
    }
}