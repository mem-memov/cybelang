<?php
require __DIR__.'/../vendor/autoload.php';

$nodePath = '';
$keyPath = '';
$valuePath = '';
    
$stores = new MemMemov\Cybelang\GraphStore\GraphStores();
$store = $stores->arrayStore($nodePath, $keyPath, $valuePath);

$rootName = 'root';
$graphs = new MemMemov\Cybelang\SpaceGraph\SpaceGraphs($store, $rootName);
$graph = $graphs->create();


