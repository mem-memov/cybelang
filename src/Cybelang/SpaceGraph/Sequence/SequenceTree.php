<?php

namespace MemMemov\Cybelang\SpaceGraph\Sequence;

use MemMemov\Cybelang\SpaceGraph\Node\Node;
use MemMemov\Cybelang\SpaceGraph\Node\Nodes;
use MemMemov\Cybelang\SpaceGraph\Space\Spaces;

class SequenceTree
{
    private $treeNode;
    private $sequenceNode;
    private $nodes;
    private $spaces;

    public function __construct(
        Node $treeNode,
        Node $sequenceNode,
        Nodes $nodes,
        Spaces $spaces
    ) {
        $this->treeNode = $treeNode;
        $this->sequenceNode = $sequenceNode;
        $this->nodes = $nodes;
        $this->spaces = $spaces;
    }

    public function getTreeNode(): Node
    {
        return $this->treeNode;
    }

    public function getSequenceNode()
    {
        return $this->sequenceNode;
    }

    public function hasPreviousTree(): bool
    {
        $treeSpace = $this->spaces->spaceOfNode($this->treeNode);
        $previousTreeNodes = $treeSpace->findNodes($this->treeNode);
        $previousTreeNodeCount = count($previousTreeNodes);

        if (0 === $previousTreeNodeCount) {
            return false;
        }

        if (1 === $previousTreeNodeCount) {
            return true;
        }

        throw new ForbidSequenceTreeToHaveManySubtrees();
    }

    public function getPreviousTree(): SequenceTree
    {
        if (!$this->hasPreviousTree()) {
            throw new ForbidMissingSequenceSubtree();
        }

        $treeSpace = $this->spaces->spaceOfNode($this->treeNode);
        $previousTreeNodes = $treeSpace->findNodes($this->treeNode);
        $previousTreeNode = $previousTreeNodes[0];

        $sequenceSpace = $this->spaces->spaceOfNode($this->sequenceNode);
        $sequenceNode = $sequenceSpace->getOneNode($previousTreeNode);

        return new SequenceTree($previousTreeNode, $sequenceNode, $this->nodes, $this->spaces);
    }

    /**
     * @return Node[]
     */
    public function collectSequenceNodes(): array
    {
        if ($this->hasPreviousTree()) {
            $previousTree = $this->getPreviousTree();
            $sequenceNodes = $previousTree->collectSequenceNodes();
        } else {
            $sequenceNodes = [];
        }

        $sequenceNodes[] = $this->sequenceNode;

        return $sequenceNodes;
    }
}