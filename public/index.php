<?php

use Bramus\Router\Router;

require __DIR__ . '/../src/vendor/autoload.php';

// Set working directory to src so that relative includes in src files work
chdir(__DIR__ . '/../src');

$router = new Router();

session_start();

$router->get('/', function () {
    // Check if user is logged in, if not redirect to sign-in page
    if (!isset($_SESSION['user_id'])) {
        header('Location: sign-in');
        exit;
    }

    require_once './../src/home-page.php';
});
$router->get('/sign-in', function () {
    require_once './../src/signin.php';
});

$router->match('GET|POST', '/processLogin', function() {
    require_once './../src/processLogin.php';
});

$router->match('GET|POST', '/processSignin', function() {
    require_once './../src/processSignin.php';
});

$router->match('GET|POST', '/processProfile', function() {
    require_once './../src/processProfile.php';
});

$router->match('GET|POST', '/chatHandler', function() {
    require_once './../src/chatHandler.php';
});

$router->get('/index', function () {
    header('Location: /' . (isset($_SERVER['QUERY_STRING']) ? '?' . $_SERVER['QUERY_STRING'] : ''));
    exit;
});

$router->get('/my-sets', function () {
    require_once './../src/my-sets.php';
});

$router->get('/create-set', function () {
    require_once './../src/create-set.php';
});

$router->get('/profile', function () {
    require_once './../src/profile.php';
});

$router->get('/learning', function () {
    require_once './../src/learning.php';
});

$router->get('/test', function () {
    require_once './../src/test.php';
});

$router->get('/learn-with-cards', function () {
    require_once './../src/learn-with-cards.php';
});

$router->get('/learn-for-test', function () {
    require_once './../src/learn-for-test.php';
});

$router->get('/edit-set', function () {
    require_once './../src/edit-set.php';
});

$router->get('/library', function () {
    require_once './../src/library.php';
});

$router->get('/create-myself', function () {
    require_once './../src/create-myself.php';
});

$router->get('/create-with-ai', function () {
    require_once './../src/create-with-ai.php';
});

$router->get('/login', function () {
    require_once './../src/login.php';
});

$router->get('/signin', function () {
    require_once './../src/signin.php';
});

$router->get('/chat', function () {
    require_once './../src/chat.php';
});

$router->match('GET|POST', '/(.*)', function($file) {
    if (file_exists($file . '.php')) {
        require_once $file . '.php';
    } else {
        header("HTTP/1.0 404 Not Found");
        echo "404 Not Found";
    }
});
$router->get('/about', function () {
    echo 'About Page Contents';
});

$router->get('/custom', function () {
    echo 'Here is my test page';
});

$router->run();