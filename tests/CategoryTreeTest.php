<?php

class CategoryTreeTest extends \PHPUnit\Framework\TestCase
{
    public function testCanConvertDatabaseResultToCategoryArray()
    {
        $tree = new \App\Services\CategoryTree();

        $db_result = [
          ['id' => 1, 'name' => 'Electronics','parent_id' => null],
          ['id' => 2, 'name' => 'Videos', 'parent_id' => null],
          ['id' => 3, 'name' => 'Software','parent_id' => null]
        ];

        $after_conversion = [
          ['id' => 1, 'name' => 'Electronics','parent_id' => null,'children' => []],
          ['id' => 2, 'name' => 'Videos', 'parent_id' => null,'children' => []],
          ['id' => 3, 'name' => 'Software','parent_id' =>null,'children' => []]
        ];

        $this->assertEquals($after_conversion,$tree->convert($db_result));
    }
}
