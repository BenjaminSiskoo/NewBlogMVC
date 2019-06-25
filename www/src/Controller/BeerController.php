<?php 

namespace App\Controller;

use \Core\Controller\Controller;

class BeerController extends Controller
{
    public function home(){
        $title = 'Brear Beer Shop';

        $this->render(
            "sitebeer/home",
            [
                "title" => $title
            ]
        );
    }
}