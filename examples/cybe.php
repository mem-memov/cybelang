<?php
require __DIR__.'/../vendor/autoload.php';

if (!file_exists(__DIR__.'/tmp')) {
    mkdir(__DIR__.'/tmp');
}

$nodePath = __DIR__.'/tmp/node_store.txt';
$keyPath = __DIR__.'/tmp/key_store.txt';
$valuePath = __DIR__.'/tmp/value_store.txt';
    
$stores = new MemMemov\Cybelang\GraphStore\GraphStores();
$store = $stores->arrayStore($nodePath, $keyPath, $valuePath);

$rootName = 'root';
$graphs = new MemMemov\Cybelang\SpaceGraph\SpaceGraphs();
$graph = $graphs->create($store, $rootName);

$parser = new MemMemov\Cybelang\Cybe\Parser\PlainText\PlainText();

$cybes = new MemMemov\Cybelang\Cybe\Cybes();
$cybe = $cybes->create($graph, $parser->messages());

$author = $cybe->createAuthor();
$message = 'птица.летит(куда:гнездо)';
$author->write($message);

var_export(unserialize(file_get_contents($nodePath)));
var_export(unserialize(file_get_contents($keyPath)));
var_export(unserialize(file_get_contents($valuePath)));

