<?php

namespace MemMemov\SpaceGraph;

class SpaceNodes
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

    public function provideCommonNode(string $spaceName, array $ids): SpaceNode
    {
        $idNodes = $this->nodes->readMany($ids);

        $uniqueSpaces = $this->spaces->uniqueSpacesOfNodes($idNodes);
        $uniqueSpaceNodes = [];
        foreach ($uniqueSpaces as $uniqueSpace) {
            $uniqueSpaceNodes[$uniqueSpace->id()] = $uniqueSpace->filter($idNodes);
        }

        $commonNodes = $this->nodes->commonNodes($ids);
        $matchingCommonNodes = [];
        foreach ($commonNodes as $commonNode) {
            $isMatching = true;
            foreach ($uniqueSpaces as $uniqueSpace) {
                $memberNodes = $uniqueSpace->filter($commonNode->all());
                foreach ($uniqueSpaceNodes[$uniqueSpace->id()] as $uniqueSpaceNode) {
                    if (!$uniqueSpaceNode->in($memberNodes)) {
                        $isMatching = false;
                        break;
                    }
                }
                if (!$isMatching) {
                    break;
                }
            }
            if ($isMatching) {
                $matchingCommonNodes[] = $commonNode;
            }
        }

        $matchingCommonNodeCount = count($matchingCommonNodes);

        if (1 === $matchingCommonNodeCount) {
            return new SpaceNode($matchingCommonNodeCount[0], $this->spaces);
        }

        if (0 === $matchingCommonNodeCount) {
            $newCommonNode = $this->nodes->createCommonNode($idNodes);
            $space = $this->spaces->provideSpace($spaceName);
            $space->add($newCommonNode);
            return new SpaceNode($newCommonNode, $this->spaces);
        }

        throw new ForbidMultipleCommonNodes('Multiple common nodes detected');
    }

    public function provideNodeForValue(string $spaceName, string $value): SpaceNode
    {
        $valueNode = $this->nodes->nodeForValue($value);
        $space = $this->spaces->provideSpace($spaceName);

        if (!$space->has($valueNode)) {
            $space->add($valueNode);
        }

        return new SpaceNode($valueNode, $this->spaces);
    }

    public function valueOfNode(SpaceNode $spaceNode): string
    {
        return $this->nodes->valueForNode();
    }

    public function read(int $id): SpaceNode
    {
        $node = $this->nodes->read($id);
        $space = $this->spaces->spaceOfNode($node);

        return new SpaceNode($node, $this->spaces);
    }
}