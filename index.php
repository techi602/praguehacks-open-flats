<?php
require 'vendor/autoload.php';

// Prepare app
$app = new \Slim\Slim(array(
    'templates.path' => 'templates',
    'debug' => in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1')),
    'view' => '\Slim\LayoutView',
    'layout' => 'layout.php',
));

$app->get('/', function () use ($app) {
    $years = (int) date('Y') - 2000;
    $data = json_decode(file_get_contents('data/main.json'));
    $app->render('main.php', array(
        'years' => $years,
        'page' => 'home',
        'data' => $data,
    ));
});

$app->get('/maps', function () use ($app) {

    /*
    $client = new Zend\Http\Client();
    $client->setUri('http://localhost');
    $response = $client->send();
    $body = $response->getBody();
    echo $body;
    die;
    */

    $app->render('maps.php', array(
        'page' => 'maps',
        'data' => array(),
    ));

});

$app->get('/google', function () use ($app) {
    $app->render('google.php', array(
        'page' => 'google',
        'data' => array(),
    ));
});


$app->get('/detail', function () use ($app) {
    $app->render('detail.php', array(
        'page' => 'detail',
        'data' => array(
            'id' => $_GET['id'],
        ),
    ));
});

$app->view()->set('baseUrl', '/praguehacks');
$app->run();

