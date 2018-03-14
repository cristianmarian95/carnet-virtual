<?php
// Initialize the Container
$container = $app->getContainer();

// Database
$capsule = new \Illuminate\Database\Capsule\Manager;
$capsule->addConnection($container['settings']['database']);
$capsule->setAsGlobal();
$capsule->bootEloquent();

// Flash Messages
$container['flash'] = function () {
    return new \Slim\Flash\Messages();
};

// Database
$container['db'] = function ($c) use ($capsule){
    return $capsule;
};

// Session
$container['session'] = function ($c){
    return new \App\Helpers\SessionHelper();
};

// Validator
$container['v'] = function ($c){
    return new \Violin\Violin();
};

// Allocation Helper
$container['functions'] = function ($c){
    return new \App\Helpers\FunctionsHelper($c);
};

// Twig View
$container['view'] = function ($c) {
    $settings = $c->get('settings')['renderer'];
    $view = new \Slim\Views\Twig($settings['template_path']);
    $basePath = rtrim(str_ireplace('index.php', '', $c['request']->getUri()->getBasePath()), '/');
    $view->addExtension(new \Slim\Views\TwigExtension($c['router'], $basePath));
    $view->getEnvironment()->addGlobal('url', $c['request']->getUri()->getBaseUrl());
    $view->getEnvironment()->addGlobal('flash', $c['flash']);
    $view->getEnvironment()->addGlobal('session', $c['session']);
    $view->getEnvironment()->addGlobal('function', $c['functions']);

    /* ========= Profile ========== */
    if($c['session']->exists('uid')){
        $profil = $c['db']->table('users')->where('id', '=', $c['session']->get('uid'))->first();
        $view->getEnvironment()->addGlobal('profil', $profil);
    }

    /* ========= Colleges ========= */
    $colleges = $c['db']->table('colleges')->get();
    $view->getEnvironment()->addGlobal('colleges', $colleges);

    /* ========= Sections ========= */
    $sections = $c['db']->table('sections')->get();
    $view->getEnvironment()->addGlobal('sections', $sections);

    /* ========= Allocations ========= */
    $allocations = $c['db']->table('allocations')->get();
    $view->getEnvironment()->addGlobal('allocations', $allocations);

    return $view;
};


/* ====================== Controllers =========================== */
$container['Portal'] = function ($c) {
    return new \App\Controllers\PortalController($c);
};
$container['Auth'] = function ($c) {
    return new \App\Controllers\AuthController($c);
};
$container['Install'] = function ($c) {
    return new \App\Controllers\InstallController($c);
};
$container['Student'] = function ($c) {
    return new \App\Controllers\StudentController($c);
};
$container['Dashboard'] = function ($c) {
    return new \App\Controllers\DashboardController($c);
};
$container['Actions'] = function ($c) {
    return new \App\Controllers\ActionController($c);
};
$container['Courses'] = function ($c) {
    return new \App\Controllers\CoursesController($c);
};
$container['Grades'] = function ($c) {
    return new \App\Controllers\GradesController($c);
};
$container['Statistici'] = function ($c){
  return new \App\Controllers\StatsController($c);
};