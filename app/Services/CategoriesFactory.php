<?php

namespace App\Services;

use App\Models\Category;

class CategoriesFactory
{
    public static function create(): array
    {
        //get categories from database
        //convert result to nested array
        //convert to string

        $categories = Category::all()->toArray();
        $htmlList = new HtmlList();
        $converted_array = $htmlList->convert($categories);

        $selectList = new ForSelectList();

        return [
            'menu_categories' => $htmlList->makeUlList($converted_array),
            'select_list_categories' => $selectList->makeSelectList($converted_array)
        ];
    }
}
