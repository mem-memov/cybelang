<?php

namespace MemMemov\Cybelang\SpaceGraph\Space;

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
        $spaceId = $space->id();
        $spaceName = $space->name();

        if (
            $this->hasSpaceWithId($spaceId)
            && $this->getSpaceWithId($spaceId) !== $space
        ) {
            throw new ForbidNonUniqueInstancesInCache($spaceId);
        }

        if (
            $this->hasSpaceWithName($spaceName)
            && $this->getSpaceWithName($spaceName) !== $space
        ) {
            throw new ForbidNonUniqueInstancesInCache($spaceId);
        }

        $this->spacesById[$spaceId] = $space;
        $this->spacesByName[$spaceName] = $space;
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

    public function getSpaceWithId(int $id): Space
    {
        if (!$this->hasSpaceWithId($id)) {
            throw new ComplainAboutItemsMissingInCache($id);
        }

        return $this->spacesById[$id];
    }

    public function getSpaceWithName(string $spaceName): Space
    {
        if (!$this->hasSpaceWithName($spaceName)) {
            throw new ComplainAboutItemsMissingInCache($spaceName);
        }

        return $this->spacesByName[$spaceName];
    }
}