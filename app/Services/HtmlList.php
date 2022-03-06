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
        $this->categoryList .= self::HTML_UL_OPEN;

        foreach ($converted_db_array as $value)
        {
            $this->categoryList .= self::HTML_LI_OPEN . $value['name'];
            if (!empty($value['children']))
            {
                 $this->makeUlList($value['children']);
            }
            $this->categoryList .= self::HTML_LI_CLOSE;
        }
        $this->categoryList .= self::HTML_UL_CLOSE;
        return $this->categoryList;
    }
}
