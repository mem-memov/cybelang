<?php
require __DIR__.'/../vendor/autoload.php';

if (!file_exists(__DIR__.'/tmp')) {
    mkdir(__DIR__.'/tmp');
}

$nodePath = __DIR__.'/tmp/node_store.txt';
$keyPath = __DIR__.'/tmp/key_store.txt';
$valuePath = __DIR__.'/tmp/value_store.txt';

$fakeLogger = new Monolog\Logger('fake');
$fakeLogger->pushHandler(new Monolog\Handler\NullHandler(Monolog\Logger::INFO));
    
$cybeLogger = new Monolog\Logger('-cybe');
$cybeLogger->pushHandler(new Monolog\Handler\StreamHandler('php://stdout', Monolog\Logger::INFO));

$spacelogger = new Monolog\Logger('--space');
$spacelogger->pushHandler(new Monolog\Handler\StreamHandler('php://stdout', Monolog\Logger::INFO));

$storelogger = new Monolog\Logger('---store');
$storelogger->pushHandler(new Monolog\Handler\StreamHandler('php://stdout', Monolog\Logger::INFO));

$stores = new MemMemov\Cybelang\GraphStore\GraphStores();
$store = $stores->arrayStore($nodePath, $keyPath, $valuePath, $storelogger);

$rootName = 'root';
$graphs = new MemMemov\Cybelang\SpaceGraph\SpaceGraphs();
$graph = $graphs->create($store, $rootName, $spacelogger);

$parser = new MemMemov\Cybelang\Cybe\Parser\PlainText\PlainText();

$cybes = new MemMemov\Cybelang\Cybe\Cybes();
$cybe = $cybes->create($graph, $parser->messages(), $cybeLogger);

$author = $cybe->createAuthor();

$message = 'птица.лететь(куда:гнездо)';
$message .= 'гнездо.расположить(где:дерево)';
$utteranceId = $author->write($message);

$message = 'птица.нести(что:еда,кому:птенцы)';
$message .= 'птенцы.хотеть есть(как:сильно)';
$utteranceId_1 = $author->writeInContext($message, [$utteranceId]);
 
$text = $author->recall(3);

var_export($text . "\n");

//var_export(unserialize(file_get_contents($nodePath)));
//var_export(unserialize(file_get_contents($keyPath)));
//var_export(unserialize(file_get_contents($valuePath)));

