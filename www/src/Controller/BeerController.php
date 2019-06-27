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
            $this->generateUrl('boutique')
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
}