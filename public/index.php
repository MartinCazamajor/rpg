<?php
require_once __DIR__ . '/../vendor/autoload.php';

$loader = new Twig\Loader\FilesystemLoader(__DIR__.'/../view');
$twig = new Twig\Environment($loader);



$rooting = explode("/",$_SERVER['REQUEST_URI']);

$controler = 'App\Controller\\' . $rooting[1];
$method = $rooting[2];

$twigChoice = new $controler;
$test = $twigChoice->$method();


echo $twig->render($test['view'], $test['parameter']);



