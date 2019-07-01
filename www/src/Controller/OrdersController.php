<?php 

namespace App\Controller;

use \Core\Controller\Controller;


class OrdersController extends Controller
{
    public function __construct()
    {
        $this->loadModel('beer');
        $this->loadModel('users');
    }

    public function home()
    {
        $paginatedQuery = new PaginatedQueryAppController(
            $this->beer,
            $this->generateUrl('boutique')
        );
        
        $articles = $paginatedQuery->getItems();
        $title = 'Brear Beer Shop Bon de Commande';
        //dd($_SESSION['auth']->getLastname());
        return $this->render(
            "orders/home",
            [
                "title" => $title,
                "articles" => $articles,
                "paginate" => $paginatedQuery->getNavHtml()
            ]
        );
    }
}