<?php

namespace MemMemov\Cybelang\SpaceGraph;

class Cluster
{
    /** @var int */
    protected $spaceId;
    /** @var int[] */
    protected $nodes;

    public function __construct(
        int $spaceId,
        array $nodeIds
    ) {
        $this->spaceId = $spaceId;
        $this->nodeIds = $nodeIds;
    }

    public function spaceId(): int
    {
        return $this->spaceId();
    }

    public function nodeIds(): array
    {
        return $this->nodeIds;
    }

    public function equals(Cluster $cluster): bool
    {
        if ($this->spaceId() !== $cluster->spaceId()) {
            return false;
        }

        if (0 !== count(array_diff($this->nodeIds(), $cluster->nodeIds()))) {
            return false;
        }

        if (0 !== count(array_diff($cluster->nodeIds(), $this->nodeIds()))) {
            return false;
        }

        return true;
    }
}