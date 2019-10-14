<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ItemStatusFixture
 */
class ItemStatusFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'item_status';
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'ITEM_ID' => ['type' => 'integer', 'length' => null, 'null' => true, 'default' => null, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'ITEM_STATUS' => ['type' => 'integer', 'length' => null, 'null' => true, 'default' => null, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'ITEM_STATUS_DATE' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => null, 'precision' => null],
        'ITEM_STATUS_OPERATOR' => ['type' => 'string', 'length' => '10', 'null' => true, 'default' => null, 'comment' => null, 'precision' => null, 'fixed' => null, 'collate' => null],
        '_indexes' => [
            'ITEM_STATUS_ITEM_ID_IDX' => ['type' => 'index', 'columns' => ['ITEM_ID', 'ITEM_STATUS'], 'length' => []],
        ],
    ];
    // @codingStandardsIgnoreEnd
    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'ITEM_ID' => 1,
                'ITEM_STATUS' => 1,
                'ITEM_STATUS_DATE' => '2019-10-14 16:42:16',
                'ITEM_STATUS_OPERATOR' => 'Lorem ip'
            ],
        ];
        parent::init();
    }
}
