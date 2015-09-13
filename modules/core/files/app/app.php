<?php

$config = require_once __DIR__ . '/bootstrap.php';

$app = new Silex\Application();

// production environment - false; test environment - true
$app['debug'] = true;

//handling CORS preflight request
$app->before(function (Symfony\Component\HttpFoundation\Request $request) {
    if ($request->getMethod() === "OPTIONS") {
        $response = new \Symfony\Component\HttpFoundation\ResponseHeaderBag();
        $response->headers->set("Access-Control-Allow-Origin", "*");
        $response->headers->set("Access-Control-Allow-Methods", "GET,POST,PUT,DELETE,OPTIONS");
        $response->headers->set("Access-Control-Allow-Headers", "Content-Type");
        $response->setStatusCode(200);
        return $response->send();
    }
}, \Silex\Application::EARLY_EVENT);

//handling CORS respons with right headers
$app->after(function (Symfony\Component\HttpFoundation\Request $request, Symfony\Component\HttpFoundation\Response $response) {
    $response->headers->set("Access-Control-Allow-Origin", "*");
    $response->headers->set("Access-Control-Allow-Methods", "GET,POST,PUT,DELETE,OPTIONS");
});

// setting up json request data
$app->before(function (Symfony\Component\HttpFoundation\Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});

$app->register(new Silex\Provider\ServiceControllerServiceProvider());
$app->register(new Silex\Provider\DoctrineServiceProvider(), $config['db']);

$app->error(function (\Exception $e, $code) use($app) {
    return $app->json(array("error" => $e->getMessage()), $code);
});

return $app;
