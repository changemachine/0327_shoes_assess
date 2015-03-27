<?php

    require_once __DIR__."/../vendor/autoload.php";
    //Don't forget AUTOLOAD EVER AGAIN!

    require_once __DIR__.'/../src/Store.php';
    require_once __DIR__.'/../src/Brand.php';

    $app = new Silex\Application();

    $app['debug'] = true;

    $DB = new PDO('pgsql:host=localhost;dbname=shoes');

    $app->register(new Silex\Provider\TwigServiceProvider(), array('twig.path' => __DIR__.'/../views'));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    //HOME, DISPLAY BRANDS  use($app)!
    $app->get("/", function() use($app){
        return $app['twig']->render('index.twig', array('brands'=> Brand::GetAll()));
    });

    $app->get("/new_brand{id}", function({id}) use($app){
        return $app['twig']->render('new_brand.twig', array('stores'=> Store::GetAll()));
    });







    return $app;


?>
