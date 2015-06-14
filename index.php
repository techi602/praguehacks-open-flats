<?php
require 'vendor/autoload.php';

$dev = in_array($_SERVER['REMOTE_ADDR'], array('127.0.0.1', '::1'));

// Prepare app
$app = new \Slim\Slim(array(
    'templates.path' => 'templates',
    'debug' => $dev,
    'view' => '\Slim\LayoutView',
    'layout' => 'layout.php',
));

if ($dev) {
    $dataUrl = '/praguehacks/data/flats-geo.json';
    $baseUrl = '/praguehacks';
} else {
    $dataUrl = 'http://praguehacks-open-flats-data.mybluemix.net/flats';
    $baseUrl = '';
}

$app->get('/', function () use ($app) {
    $years = (int) date('Y') - 2000;
    $data = json_decode(file_get_contents('data/main.json'));
    $app->render('main.php', array(
        'years' => $years,
        'page' => 'home',
        'data' => $data,
    ));
});

$app->get('/maps', function () use ($app, $baseUrl) {

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
        'js' => array(
            $baseUrl . '/assets/maps.js',
        ),
    ));
});

$app->get('/google', function () use ($app, $baseUrl) {
    $app->render('google.php', array(
        'page' => 'google',
        'data' => array(),
    ));
});

$app->get('/buildings', function () use ($app, $baseUrl) {
    $app->render('buildings.php', array(
        'page' => 'buildings',
        'title' => 'Budovy Magistrátu hlavního města Prahy',
        'js' => array(
            $baseUrl . '/assets/maps.js',
            $baseUrl . '/assets/proj4.js',
            $baseUrl . '/assets/proj4leaflet.js',
        ),
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

$app->view()->set('dataUrl', $dataUrl);
$app->view()->set('baseUrl', $baseUrl);
$app->run();
