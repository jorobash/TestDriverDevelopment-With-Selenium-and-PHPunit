<?php

namespace App\Services;

class CategoryTree
{
    public function convert(array $db_array): array
    {
        $nested_categories = array();
        foreach($db_array as $key => $category){
            $category['children'] = [];
            if($category['parent_id'] == 1){
                $key_of_parent = array_search(1,array_column($db_array,'id'));
                $key_of_child = $key;
                $db_array[$key_of_child]['children'] = [];
                $nested_categories[$key_of_parent]['children'][] = $db_array[$key_of_child];
            }else{
                $nested_categories[] = $category;
            }

        }

        return $nested_categories;
    }
}
