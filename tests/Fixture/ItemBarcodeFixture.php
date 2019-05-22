<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ItemBarcodeFixture
 */
class ItemBarcodeFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'ITEM_BARCODE';
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'ITEM_ID' => ['type' => 'integer', 'length' => null, 'null' => true, 'default' => null, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'ITEM_BARCODE' => ['type' => 'string', 'length' => '30', 'null' => true, 'default' => null, 'comment' => null, 'precision' => null, 'fixed' => null, 'collate' => null],
        'BARCODE_STATUS' => ['type' => 'integer', 'length' => null, 'null' => true, 'default' => null, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'BARCODE_STATUS_DATE' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => null, 'precision' => null],
        '_indexes' => [
            'ITEM_BARCODE_ITM_IDX' => ['type' => 'index', 'columns' => ['ITEM_ID'], 'length' => []],
            'ITEM_BARCODE_BAR_IDX' => ['type' => 'index', 'columns' => ['ITEM_BARCODE'], 'length' => []],
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
                'ITEM_BARCODE' => 'Lorem ipsum dolor sit amet',
                'BARCODE_STATUS' => 1,
                'BARCODE_STATUS_DATE' => '2019-04-17 20:43:09'
            ],
        ];
        parent::init();
    }
}
