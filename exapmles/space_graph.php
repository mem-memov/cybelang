<?php
require __DIR__.'/../vendor/autoload.php';

$nodePath = '';
$keyPath = '';
$valuePath = '';
    
$store = new MemMemov\Cybelang\GraphStore\GraphStores($nodePath, $keyPath, $valuePath);

$rootName = 'root';
$graph = new MemMemov\Cybelang\SpaceGraph\SpaceGraphs($store, $rootName);

