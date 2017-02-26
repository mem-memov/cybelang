<?php

namespace MemMemov\Cybelang\SpaceGraph;

class Cluster
{
    /** @var int */
    protected $spaceId;
    /** @var int[] */
    protected $nodeIds;

    public function __construct(
        int $spaceId,
        array $nodeIds
    ) {
        $this->spaceId = $spaceId;
        $this->nodeIds = $nodeIds;
    }

    public function spaceId(): int
    {
        return $this->spaceId;
    }

    public function nodeIds(): array
    {
        return $this->nodeIds;
    }

    public function equals(Cluster $cluster): bool
    {
        if ($this->spaceId !== $cluster->spaceId()) {
            return false;
        }

        $clusterNodeIds = $cluster->nodeIds();

        if (0 !== count(array_diff($this->nodeIds, $clusterNodeIds))) {
            return false;
        }

        if (0 !== count(array_diff($clusterNodeIds, $this->nodeIds))) {
            return false;
        }

        return true;
    }
}