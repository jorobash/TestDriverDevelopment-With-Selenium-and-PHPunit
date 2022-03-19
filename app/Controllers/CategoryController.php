<?php

namespace App\Controllers;

use App\Models\Category;

class CategoryController extends BaseController
{
    public function deleteCategory($request,$response,$args)
    {

        $categoryId = $args['id'];
        $category = Category::find($categoryId);
        $category->delete();
        $_SESSION['category_delete'] = true;
        return $response->withRedirect('http://localhost:2143/PHPUnitSeleniumAndTDD/TestDrivernDevelopment/public/', 301);
//        return $this->container->view->render($response,'home.phtml',[
//            'category_deleted' => true
//        ]);
    }

    public function showCategory($request,$response,$args)
    {
        $categoryId = $args['id'];
        $category = Category::find($categoryId);

        return $this->container->view->render($response,'home.phtml',[
            'category' => $category
        ]);
    }

    public function editCategory($request,$response,$args)
    {

        $categoryId = $args['id'];
        $category = Category::find($categoryId);

        return $this->container->view->render($response,'home.phtml',[
           'editCategory' => $category
        ]);
    }

    public function saveCategory($request,$response,$args)
    {
        $data = $request->getParsedBody();
        if(empty($data['category_name']) || empty($data['category_description'])){
            $categorySaved = false;
        }
        else{

            if(isset($data['category_id'])){
                $category = Category::find($data['category_id']);

            }else{
                $category = new Category;
            }

            $category->name = $data['category_name'];
            $category->description = $data['category_description'];
            $category->parent_id = !empty($data['category_parent'])
                ? $data['category_parent'] : null;
            $category->save();

            $categorySaved = true;
        }
        return $this->container->view->render($response,'home.phtml',[
            'categorySaved' => $categorySaved
        ]);
    }

    public function compareStrings()
    {
//        $stinrg1 = "<li><a href="http://localhost:2143/PHPUnitSeleniumAndTDD/TestDrivernDevelopment/public/show-category/1,Electronics">Electronics</a></li><li><a href="http://localhost:2143/PHPUnitSeleniumAndTDD/TestDrivernDevelopment/public/show-category/2,Videos">Videos</a></li><li><a href="http://localhost:2143/PHPUnitSeleniumAndTDD/TestDrivernDevelopment/public/show-category/3,Software">Software</a></li>";
//        $sting2 = "<li><a href='http://localhost:2143/PHPUnitSeleniumAndTDD/TestDrivernDevelopment/public/show-category/1,Electronics'>Electronics</a></li><li><a href='http://localhost:2143/PHPUnitSeleniumAndTDD/TestDrivernDevelopment/public/show-category/2,Videos'>Videos</a></li><li><a href='http://localhost:2143/PHPUnitSeleniumAndTDD/TestDrivernDevelopment/public/show-category/3,Software'>Software</a></li>";
//        var_dump($sting2 == $stinrg1);
    }
}

//(new CategoryController())->compareStrings();
