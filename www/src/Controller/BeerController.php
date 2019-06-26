<?php 

namespace App\Controller;

use \Core\Controller\Controller;


class BeerController extends Controller
{
    public function __construct()
    {
        $this->loadModel('beer');
    }

    public function home(){
        $title = 'Brear Beer Shop';
        // sitebeer/home : sitebeer correspond au dossier dans views et home correspond au fichier home.twig dans views/sitebeer
        $this->render(
            "sitebeer/home",
            [
                "title" => $title
            ]
        );
    }

    public function all()
    {
        $paginatedQuery = new PaginatedQueryAppController(
            $this->beer,
            $this->generateUrl('boutique'), 3
        );
        
        $articles = $paginatedQuery->getItems();

        $title = 'My Bread Beer Shop';
        $this->render(
            'sitebeer/boutique',
            [
                "title" => $title,
                "articles" => $articles,
                "paginate" => $paginatedQuery->getNavHtml()
            ]
        );
    }
    public function signup()
    {
        $title = 'My Bread Beer Inscription';
        $this->render(
            'users/signup',
            [
                "title" => $title
            ]
        );
    }

    public function signin()
    {
        $title = 'My Bread Beer Connexion';
        $this->render(
            'users/signin',
            [
                "title" => $title
            ]
        );
    }
}