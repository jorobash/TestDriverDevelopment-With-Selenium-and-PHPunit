<?php

namespace App\Services;

class HtmlList extends CategoryTree
{
    const HTML_UL_OPEN = '<ul>';
    const HTML_UL_CLOSE = '</ul>';
    const HTML_LI_OPEN = '<li>';
    const HTML_LI_CLOSE = '</li>';

    public function makeUlList(array $converted_db_array)
    {
//        foreach ($converted_db_array as $value)
//        {
//            $this->categoryList .= self::HTML_LI_OPEN."<a href='http://localhost:2143/PHPUnitSeleniumAndTDD/TestDrivernDevelopment/public/show-category/{$value['id']},{$value['name']}'>".$value['name']."</a>";
//            if (!empty($value['children']))
//            {
//                $this->categoryList .= '<ul class="submenu menu vertical" data-submenu>';
//                 $this->makeUlList($value['children']);
//                $this->categoryList .= '</ul>';
//            }
//            $this->categoryList .= self::HTML_LI_CLOSE;
//        }
//        return $this->categoryList;

        foreach ($converted_db_array as $value)
        {
            $this->categoryList .= '<li><a href="http://localhost:2143/PHPUnitSeleniumAndTDD/TestDrivernDevelopment/public/show-category/'.$value['id'].','.$value['name'].'">'.$value['name'].'</a>';
            if (!empty($value['children']))
            {
                $this->categoryList .= '<ul class="submenu menu vertical" data-submenu>';
                $this->makeUlList($value['children']);
                $this->categoryList .= '</ul>';
            }
            $this->categoryList .= '</li>';
        }
        return $this->categoryList;
    }
}
