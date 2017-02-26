<?php

namespace MemMemov\Cybelang\SpaceGraph;

class SpaceNodes implements SpaceNodesInNode, SpaceNodesInGraph
{
    private $nodes;
    private $spaces;
    private $commonNodes;

    public function __construct(
        Nodes $nodes,
        Spaces $spaces,
        CommonNodes $commonNodes
    ) {
        $this->nodes = $nodes;
        $this->spaces = $spaces;
        $this->commonNodes = $commonNodes;
    }

    public function readNode(int $id): SpaceNode
    {
        $node = $this->nodes->read($id); // checking it exsits and loading to cache

        return new SpaceNode($id, $this);
    }

    /**
     * @param string $spaceName
     * @param int[] $ids
     * @return SpaceNode
     * @throws ForbidMultipleCommonNodes
     */
    public function provideCommonNode(string $spaceName, array $ids): SpaceNode
    {
        $space = $this->spaces->provideSpace($spaceName);

        $matchingCommonNodes = $this->commonNodes->provideMatchingCommonNodes($space, $ids);

        $matchingCommonNodeCount = count($matchingCommonNodes);

        if (1 === $matchingCommonNodeCount) {
            $commonNode = $matchingCommonNodes[0];
            if (!$space->has($commonNode)) {
                throw new NodeNotFoundInSpace($commonNode->id());
            }
            return new SpaceNode($commonNode->id(), $this);
        }

        if (0 === $matchingCommonNodeCount) {
            $nodes = $this->nodes->readMany($ids);
            $commonNode = $space->createCommonNode($nodes);
            return new SpaceNode($commonNode->id(), $this);
        }

        throw new ForbidMultipleCommonNodes('Multiple common nodes detected');
    }

    public function getOneNode(string $spaceName, int $id): SpaceNode
    {
        $containerNode = $this->nodes->read($id);
        $space = $this->spaces->provideSpace($spaceName);
        $node = $space->getOneNode($containerNode);

        return new SpaceNode($node->id(), $this);
    }

    /**
     * @param string $spaceName
     * @param int $id
     * @return SpaceNode[]
     */
    public function findNodes(string $spaceName, int $id): array
    {
        $containerNode = $this->nodes->read($id);
        $space = $this->spaces->provideSpace($spaceName);
        $nodes = $space->findNodes($containerNode);

        $spaceNodes = [];
        foreach ($nodes as $node) {
            $spaceNodes[] = new SpaceNode($node->id(), $this);
        }

        return $spaceNodes;
    }

    public function provideNodeForValue(string $spaceName, string $value): SpaceNode
    {
        $space = $this->spaces->provideSpace($spaceName);
        $node = $space->createNodeForValue($value);

        return new SpaceNode($node->id(), $this);
    }

    public function valueOfNode(int $id): string
    {
        $node = $this->nodes->read($id);

        return $this->nodes->valueForNode($node);
    }

    /**
     * @param string $spaceName
     * @param int[] $ids
     * @return SpaceNode
     */
    public function provideSequenceNode(string $spaceName, array $ids): SpaceNode
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

        return new SpaceNode($lastNode->id(), $this);
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
        $spaceNode = new SpaceNode($node->id(), $this);

        $previousNodes = $lastNodeSpace->findNodes($lastNode);
        $previousNodeCount = count($previousNodes);

        if (0 === $previousNodeCount) {
            return [$spaceNode];
        }

        if (1 === $previousNodeCount) {
            $previousNode = $previousNodes[0];
            $sequence = $this->readNodeSequence($spaceName, $previousNode->id());
            $sequence[] = $spaceNode;
            return $sequence;
        }
    }
}