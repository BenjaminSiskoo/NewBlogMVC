<?php
$basePath = dirname(__dir__) . DIRECTORY_SEPARATOR;

require_once $basePath . 'vendor/autoload.php';

$app = App\App::getInstance();
$app->setStartTime();
$app::load();

$app->getRouter($basePath)
    ->get('/', 'Beer#home', 'home')
    ->get('/boutique', 'Beer#all', 'boutique')
    ->get('/signup', 'Beer#signup', 'signup')   
    ->post('/signup', 'Beer#signup', 'post_signup') 
    ->get('/signin', 'Beer#signin', 'signin')   
    ->post('/signin', 'Beer#signin', 'post_signin')  
    ->get('/index', 'Post#all', 'blog')
    ->get('/categories', 'Category#all', 'categories')
    ->get('/category/[*:slug]-[i:id]', 'Category#show', 'category')
    ->get('/article/[*:slug]-[i:id]', 'post#show', 'post')
    ->get('/test', 'Twig#index', 'test')
    ->run();
