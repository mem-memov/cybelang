<?php

namespace MemMemov\Cybelang\SpaceGraph\CommonNode;

/**
 * Class ForbidMultipleCommonNodes is an exception
 * thrown in case when more than one node exists that have the same set of connections
 * in specified spaces of the graph.
 * @package MemMemov\Cybelang\SpaceGraph
 */
class ForbidMultipleCommonNodes extends \Exception
{

}