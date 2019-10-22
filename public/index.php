<?php
require_once __DIR__ . '/../vendor/autoload.php';

$loader = new Twig\Loader\FilesystemLoader(__DIR__ . '/../src/view');
$twig = new Twig\Environment($loader);



$rooting = explode("/",$_SERVER['REQUEST_URI']);

$controler = 'App\Controller\\' . $rooting[1];
$model = $rooting[2];
$parameter = isset($rooting[3]) ? $rooting[3]: null;

$twigChoice = new $controler;
$test = $twigChoice->$model($parameter);


echo $twig->render($test['view'], $test['parameter']);



