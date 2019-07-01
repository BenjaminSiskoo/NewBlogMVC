<?php
$basePath = dirname(__dir__) . DIRECTORY_SEPARATOR;

require_once $basePath . 'vendor/autoload.php';

$app = App\App::getInstance();
$app->setStartTime();
$app::load();

$app->getRouter($basePath)
    ->get('/', 'Beer#home', 'home')
    ->get('/boutique', 'Beer#all', 'boutique')
    ->get('/signup', 'Users#signup', 'signup') 
    ->post('/signup', 'Users#signup', 'post_signup') 
    ->get('/signin', 'Users#signin', 'signin')   
    ->post('/signin', 'Users#signin', 'post_signin')
    ->get('/signin/[*:mail]-[*:token]', 'Users#signin', 'mail_verif')
    ->get('/disconnect', 'Users#disconnect', 'disconnect')
    ->get('/purchase_order', 'Orders#home', 'purchase_order')
    ->get('/contact', 'Users#contact', 'contact')
    ->get('/profil', 'Users#profil', 'profil')
    ->post('/profil', 'Users#profil', 'post_profil')           
    ->get('/index', 'Post#all', 'blog')
    ->get('/categories', 'Category#all', 'categories')
    ->get('/category/[*:slug]-[i:id]', 'Category#show', 'category')
    ->get('/article/[*:slug]-[i:id]', 'post#show', 'post')
    ->get('/test', 'Twig#index', 'test')
    ->run();