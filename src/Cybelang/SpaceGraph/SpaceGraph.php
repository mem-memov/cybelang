<?php

namespace MemMemov\Cybelang\SpaceGraph;

use MemMemov\Cybelang\Cybe\Graph;
use MemMemov\Cybelang\Cybe\GraphNode;
use Psr\Log\LoggerInterface;

class SpaceGraph implements Graph
{
    private $spaceNodes;
    /** @var LoggerInterface */
    private $logger;

    public function __construct(
        SpaceNodesInGraph $spaceNodes,
        LoggerInterface $logger
    ) {
        $this->spaceNodes = $spaceNodes;
        $this->logger = $logger;
    }
    
    public function createNode(string $type, array $toIds, array $fromIds): GraphNode
    {
        $spaceNode = $this->spaceNodes->createNode($type, $toIds, $fromIds);
        
        $this->logger->info('node created', ['id' => $spaceNode->id(), 'space' => $type, 'to' => $toIds, 'from' => $fromIds]);
        
        return $spaceNode;
    }

    public function provideCommonNode(string $type, array $ids): GraphNode
    {
        $spaceNode = $this->spaceNodes->provideCommonNode($type, $ids);
        
        $this->logger->info('common node provided', ['id' => $spaceNode->id(), 'space' => $type, 'ids' => $ids]);
        
        return $spaceNode;
    }

    public function provideValueNode(string $type, string $value): GraphNode
    {
        $spaceNode = $this->spaceNodes->provideNodeForValue($type, $value);
        
        $this->logger->info('node provided for value', ['id' => $spaceNode->id(), 'space' => $type, 'value' => $value]);
        
        return $spaceNode;
    }

    public function getNodeValue(int $id): string
    {
        $value = $this->spaceNodes->valueOfNode($id);
        
        $this->logger->info('value provided for node', ['id' => $id, 'value' => $value]);
        
        return $value;
    }

    public function readNode(int $id): GraphNode
    {
        $spaceNode = $this->spaceNodes->readNode($id);
        
        $this->logger->info('node read', ['id' => $id]);
        
        return $spaceNode;
    }
    
    public function filterNode(string $type, int $id): array
    {
        $spaceNodes = $this->spaceNodes->filterNode($type, $id);
        
        $spaceNodeIds = [];
        foreach ($spaceNodes as $spaceNode) {
            $spaceNodeIds[] = $spaceNode->id();
        }
        
        $this->logger->info('node filtered', ['id' => $id, 'space' => $type, 'selected nodes' => $spaceNodeIds]);
        
        return $spaceNodes;
    }

    public function provideSequenceNode(string $type, array $ids): GraphNode
    {
        $spaceNode = $this->spaceNodes->provideSequenceNode($type, $ids);
        
        $this->logger->info('node provided for sequence', ['id' => $spaceNode->id(), 'space' => $type, 'ids' => $ids]);
        
        return $spaceNode;
    }

    /**
     * @return GraphNode[]
     */
    public function readSequenceNodes(string $type, int $id): array
    {
        $sequenceSpaceNodes = $this->spaceNodes->readNodeSequence($type, $id);
        
        $sequenceSpaceNodeIds = [];
        foreach ($sequenceSpaceNodes as $sequenceSpaceNode) {
            $sequenceSpaceNodeIds[] = $sequenceSpaceNode->id();
        }
        
        $this->logger->info('node sequence read', ['sequence id' => $id, 'space' => $type, 'sequence nodes' => $sequenceSpaceNodeIds]);
        
        return $sequenceSpaceNodes;
    }
    
    public function addNodeToRow(int $headId, int $newTailId): void
    {
        $this->spaceNodes->addNodeToRow($headId, $newTailId);
        
        $this->logger->info('node added to row', ['head id' => $headId, 'tail node' => $newTailId]);
    }
    
    /**
     * @return GraphNode[]
     */
    public function readRow(string $tailSpaceName, int $headId, int $limit): array
    {
        $tailSpaceNodes = $this->spaceNodes->readRow($tailSpaceName, $headId, $limit);
        
        $tailSpaceNodeIds = [];
        foreach ($tailSpaceNodes as $tailSpaceNode) {
            $tailSpaceNodeIds[] = $tailSpaceNode->id();
        }
        
        $this->logger->info('node row read', ['head id' => $headId, 'tail space' => $tailSpaceName, 'tail nodes' => $tailSpaceNodeIds, 'limit' => $limit]);
        
        return $tailSpaceNodes;
    }
}