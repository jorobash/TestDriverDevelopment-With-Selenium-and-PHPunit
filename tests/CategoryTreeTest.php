<?php

use App\Services\CategoryTree;

class CategoryTreeTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @var CategoryTree
     */
    protected $categoryTree;

    public function setUp(): void
    {
        $this->categoryTree = new CategoryTree();
    }

    public function arrayProvider()
    {
        return [
          'one level' => [
              [
                  ['id' => 1, 'name' => 'Electronics', 'parent_id' => null, 'children' => []],
                  ['id' => 2, 'name' => 'Videos', 'parent_id' => null, 'children' => []],
                  ['id' => 3, 'name' => 'Software', 'parent_id' => null, 'children' => []]
              ],
              [
                  ['id' => 1, 'name' => 'Electronics', 'parent_id' => null],
                  ['id' => 2, 'name' => 'Videos', 'parent_id' => null],
                  ['id' => 3, 'name' => 'Software', 'parent_id' => null]
              ]
          ],
          'two level' => [
              [
                  [
                      'id' => 1,
                      'name' => 'Electronics',
                      'parent_id' => null,
                      'children' => [
                          [
                              'id' => 2,
                              'name' => 'Computers',
                              'parent_id' => 1,
                              'children' => []
                          ]
                      ]
                  ]
              ],
              [
                  ['id' => 1, 'name' => 'Electronics', 'parent_id' => null],
                  ['id' => 2, 'name' => 'Computers', 'parent_id' => 1]
              ]
          ],
          'three level' => [
              [
                  [
                      'id' => 1,
                      'name' => 'Electronics',
                      'parent_id' => null,
                      'children' => [
                          [
                              'id' => 2,
                              'name' => 'Computers',
                              'parent_id' => 1,
                              'children' => [
                                  [
                                      'id' => 3,
                                      'name' => 'Laptops',
                                      'parent_id' => 2,
                                      'children' => []
                                  ]
                              ]
                          ]
                      ]
                  ]
              ],
              [
                  ['id' => 1, 'name' => 'Electronics', 'parent_id' => null],
                  ['id' => 2, 'name' => 'Computers', 'parent_id' => 1],
                  ['id' => 3, 'name' => 'Laptops', 'parent_id' => 2]
              ]
          ]
        ];
    }

    /**
     * @param $after_conversion
     * @param $db_result
     * @return void
     * @dataProvider arrayProvider
     */
    public function testCanConvertDatabaseResultToCategoryNestedArray($after_conversion,$db_result)
    {
        $this->assertEquals($after_conversion,$this->categoryTree->convert($db_result));
    }

    public function testCanConvertDatabaseResultToCategoryArray()
    {

        $db_result = [
            ['id' => 1, 'name' => 'Electronics', 'parent_id' => null],
            ['id' => 2, 'name' => 'Videos', 'parent_id' => null],
            ['id' => 3, 'name' => 'Software', 'parent_id' => null]
        ];

        $after_conversion = [
            ['id' => 1, 'name' => 'Electronics', 'parent_id' => null, 'children' => []],
            ['id' => 2, 'name' => 'Videos', 'parent_id' => null, 'children' => []],
            ['id' => 3, 'name' => 'Software', 'parent_id' => null, 'children' => []]
        ];

        $this->assertEquals($after_conversion, $this->categoryTree->convert($db_result));
    }

    public function testCanConvertDatabaseResultToOneLevelNestedArray()
    {
        $db_result = [
            ['id' => 1, 'name' => 'Electronics', 'parent_id' => null],
            ['id' => 2, 'name' => 'Computers', 'parent_id' => 1]
        ];

        $after_conversion = [
            [
                'id' => 1,
                'name' => 'Electronics',
                'parent_id' => null,
                'children' => [
                    [
                        'id' => 2,
                        'name' => 'Computers',
                        'parent_id' => 1,
                        'children' => []
                    ]
                ]
            ]
        ];

        $this->assertEquals($after_conversion, $this->categoryTree->convert($db_result));
    }

    public function testCanConvertDatabaseResultIntoTwoNestedLevelArray()
    {
        $db_result = [
            ['id' => 1, 'name' => 'Electronics', 'parent_id' => null],
            ['id' => 2, 'name' => 'Computers', 'parent_id' => 1],
            ['id' => 3, 'name' => 'Laptops', 'parent_id' => 2]
        ];

        $after_conversion = [
            [
                'id' => 1,
                'name' => 'Electronics',
                'parent_id' => null,
                'children' => [
                    [
                        'id' => 2,
                        'name' => 'Computers',
                        'parent_id' => 1,
                        'children' => [
                            [
                                'id' => 3,
                                'name' => 'Laptops',
                                'parent_id' => 2,
                                'children' => []
                            ]
                        ]
                    ]
                ]
            ]
        ];

        $this->assertEquals($after_conversion,$this->categoryTree->convert($db_result));
    }
}
