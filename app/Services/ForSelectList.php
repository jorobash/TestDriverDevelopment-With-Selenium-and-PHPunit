<?php

namespace App\Services;

class ForSelectList extends CategoryTree
{
    public function makeSelectList(array $after_conversion_db,int $repeat = 0)
    {
        foreach ($after_conversion_db as $value)
        {
            $this->categoryList[] = [
                'name'=> str_repeat("&nbsp;",$repeat).$value['name'],
                'id' => $value['id']
            ];

            if(!empty($value['children']))
            {
                $repeat = $repeat + 2;
                $this->makeSelectList($value['children'],$repeat);
            }

        }
        return $this->categoryList;
    }
}
