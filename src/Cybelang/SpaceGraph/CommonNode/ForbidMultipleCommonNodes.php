<?php

namespace MemMemov\Cybelang\SpaceGraph\CommonNode;

/**
 * Class ForbidMultipleCommonNodes is an exception
 * thrown in case when more than one node exists that have the same set of connections
 * in specified spaces of the graph.
 */
class ForbidMultipleCommonNodes extends \Exception
{

}