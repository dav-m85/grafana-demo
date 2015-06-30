<?php

require_once __DIR__.'/vendor/autoload.php';

use Liuggio\StatsdClient\StatsdClient,
    Liuggio\StatsdClient\Factory\StatsdDataFactory,
    Liuggio\StatsdClient\Sender\SocketSender,
    Liuggio\StatsdClient\Service\StatsdService;

$sender  = new SocketSender(
	getenv('STATSD_PORT_8125_UDP_ADDR'),
	getenv('STATSD_PORT_8125_UDP_PORT'),
	'udp'
);
$client  = new StatsdClient($sender);
$factory = new StatsdDataFactory('\Liuggio\StatsdClient\Entity\StatsdData');
$statsd  = new StatsdService($client, $factory);

// create the metrics with the service
/*
$service->timing('usageTime', 100);
$service->decrement('click');
$service->gauge('gaugor', 333);
$service->set('uniques', 765);
*/

$app = new Silex\Application();
$app['debug'] = true;

// Pages
$app->get('/', function() use($statsd){
	$statsd->increment(gethostname().'.render.home')->flush();
	return "Home";
});

$app->get('/a', function() use($statsd){
	$statsd->increment(gethostname().'.render.a')->flush();
	return "A";
});

$app->get('/b', function() use($statsd){
	$statsd->increment(gethostname().'.render.b')->flush();
	return "B";
});

$app->run();
