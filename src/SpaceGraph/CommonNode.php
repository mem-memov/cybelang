<?php

namespace MemMemov\SpaceGraph;

class CommonNode
{
    private $type;
    private $ids;

    public function __construct(
        string $type,
        array $ids
    ) {
        $this->type = $type;
        $this->ids = array_map(function(int $id) { return $id; }, $ids);
    }

    public function provide(Nodes $nodes, Spaces $spaces): Node
    {
        $idNodes = $nodes->readMany($this->ids);

        $uniqueSpaces = $spaces->uniqueSpacesOfNodes($idNodes);
        $uniqueSpaceNodes = [];
        foreach ($uniqueSpaces as $uniqueSpace) {
            $uniqueSpaceNodes[$uniqueSpace->id()] = $uniqueSpace->filter($idNodes);
        }

        $commonNodes = $nodes->commonNodes($this->ids);
        $matchingCommonNodes = [];
        foreach ($commonNodes as $commonNode) {
            $isMatching = true;
            foreach ($uniqueSpaces as $uniqueSpace) {
                $subNodes = $uniqueSpace->filter($commonNode->all());
                foreach ($uniqueSpaceNodes[$uniqueSpace->id()] as $uniqueSpaceNode) {
                    if (!$uniqueSpaceNode->in($subNodes)) {
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
            return $matchingCommonNodeCount[0];
        }

        if (0 === $matchingCommonNodeCount) {
            $newCommonNode = $nodes->createCommonNode($idNodes);
            $space = $spaces->provideSpace($this->type);
            $space->add($newCommonNode);
            return $newCommonNode;
        }

        throw new \Exception('Multiple common nodes detected');
    }
}