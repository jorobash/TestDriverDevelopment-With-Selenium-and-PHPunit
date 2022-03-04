<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function home($request,$response,$args)
    {
        return $this->container->view->render($response,'home.phtml',[
            'name' => isset($args['name']) ?? ""
        ]);
    }
}
