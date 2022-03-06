<?php

namespace App\Controllers;

class HomeController extends BaseController
{
    public function home($request,$response,$args)
    {
       $electronics  = $this->container->db->table('categories')
        ->where('name','Electronics')->get();

        return $this->container->view->render($response,'home.phtml',[
            'name' => isset($args['name']) ?? ""
        ]);
    }
}
