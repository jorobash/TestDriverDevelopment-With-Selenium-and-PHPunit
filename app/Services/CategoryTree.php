<?php

namespace App\Services;

class CategoryTree
{
    public function convert(array $db_array): array
    {
        $nested_categories = array();
        foreach($db_array as $key => $category){
            $category['children'] = [];
            $nested_categories[] = $category;
        }

        return $nested_categories;
    }
}
