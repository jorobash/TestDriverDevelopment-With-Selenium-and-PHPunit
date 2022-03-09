<?php

namespace App\Controllers;

use App\Models\Category;

class HomeController extends BaseController
{
    public function home($request,$response,$args)
    {
        return $this->container->view->render($response,'home.phtml',[

        ]);
    }
}
