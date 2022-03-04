<?php

namespace App\Controllers;

class CategoryController extends BaseController
{
    public function deleteCategory($request,$response,$args)
    {

        $categoryId = $args['id'];
        return $this->container->view->render($response,'home.phtml',[
            'category_deleted' => true
        ]);
    }

    public function showCategory($request,$response,$args)
    {
        $categoryId = $args['id'];
        $category = 'Electronics';

        return $this->container->view->render($response,'home.phtml',[
            'category' => $category
        ]);
    }

    public function editCategory($request,$response,$args)
    {

        $categoryId = $args['id'];
        $category = ['name' => 'Electronics','parent' => null];
        return $this->container->view->render($response,'home.phtml',[
           'editCategory' => $category
        ]);
    }
}
