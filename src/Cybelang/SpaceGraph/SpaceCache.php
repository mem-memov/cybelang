<?php

namespace MemMemov\Cybelang\SpaceGraph;

class SpaceCache
{
    private $spacesByName;
    private $spacesById;

    public function __construct()
    {
        $this->spacesByName = [];
        $this->spacesById = [];
    }

    public function set(Space $space): void
    {
        $this->spacesByName[$space->name()] = $space;
        $this->spacesById[$space->id()] = $space;
    }

    public function hasSpaceWithName(string $spaceName): bool
    {
        return array_key_exists($spaceName, $this->spacesByName);
    }

    public function hasSpaceWithId(int $id): bool
    {
        return array_key_exists($id, $this->spacesById);
    }

    public function isEmpty(): bool
    {
        return empty($this->spacesByName) || empty($this->spacesById);
    }

    /**
     * @return Space[]
     */
    public function getAll(): array
    {
        return array_values($this->spacesByName);
    }

    public function getSpaceWithName(string $spaceName): Space
    {
        return $this->spacesByName[$spaceName];
    }
}