<?php
require __DIR__.'/../vendor/autoload.php';

if (!file_exists(__DIR__.'/tmp')) {
    mkdir(__DIR__.'/tmp');
}

$nodePath = __DIR__.'/tmp/node_store.txt';
$keyPath = __DIR__.'/tmp/key_store.txt';
$valuePath = __DIR__.'/tmp/value_store.txt';
    
$logger = new Monolog\Logger('cybe');
$logger->pushHandler(new Monolog\Handler\StreamHandler('php://stdout', Monolog\Logger::INFO));

$stores = new MemMemov\Cybelang\GraphStore\GraphStores();
$store = $stores->arrayStore($nodePath, $keyPath, $valuePath, $logger);

$rootName = 'root';
$graphs = new MemMemov\Cybelang\SpaceGraph\SpaceGraphs();
$graph = $graphs->create($store, $rootName);

$parser = new MemMemov\Cybelang\Cybe\Parser\PlainText\PlainText();

$cybes = new MemMemov\Cybelang\Cybe\Cybes();
$cybe = $cybes->create($graph, $parser->messages(), $logger);

$author = $cybe->createAuthor();
$message = 'птица.лететь(куда:гнездо)';
$message .= 'гнездо.расположить(где:дерево)';
$author->write($message);
$message = 'птица1.лететь1(куда1:гнездо1)';
$message .= 'гнездо1.расположить1(где1:дерево1)';
$author->write($message);

$message = $author->recall(3);

var_export($message . "\n");

//var_export(unserialize(file_get_contents($nodePath)));
//var_export(unserialize(file_get_contents($keyPath)));
//var_export(unserialize(file_get_contents($valuePath)));

