<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ItemFixture
 */
class ItemFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'ITEM';
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'ITEM_ID' => ['type' => 'integer', 'length' => null, 'null' => true, 'default' => null, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'PERM_LOCATION' => ['type' => 'integer', 'length' => null, 'null' => true, 'default' => null, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'TEMP_LOCATION' => ['type' => 'integer', 'length' => null, 'null' => true, 'default' => null, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'ITEM_TYPE_ID' => ['type' => 'integer', 'length' => null, 'null' => true, 'default' => null, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'TEMP_ITEM_TYPE_ID' => ['type' => 'integer', 'length' => null, 'null' => true, 'default' => null, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'COPY_NUMBER' => ['type' => 'integer', 'length' => null, 'null' => true, 'default' => null, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'ON_RESERVE' => ['type' => 'string', 'length' => '1', 'null' => true, 'default' => null, 'comment' => null, 'precision' => null, 'fixed' => null, 'collate' => null],
        'RESERVE_CHARGES' => ['type' => 'integer', 'length' => null, 'null' => true, 'default' => null, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'PIECES' => ['type' => 'integer', 'length' => null, 'null' => true, 'default' => null, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'PRICE' => ['type' => 'integer', 'length' => null, 'null' => true, 'default' => null, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'SPINE_LABEL' => ['type' => 'string', 'length' => '25', 'null' => true, 'default' => null, 'comment' => null, 'precision' => null, 'fixed' => null, 'collate' => null],
        'HISTORICAL_CHARGES' => ['type' => 'integer', 'length' => null, 'null' => true, 'default' => null, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'HISTORICAL_BROWSES' => ['type' => 'integer', 'length' => null, 'null' => true, 'default' => null, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'RECALLS_PLACED' => ['type' => 'integer', 'length' => null, 'null' => true, 'default' => null, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'HOLDS_PLACED' => ['type' => 'integer', 'length' => null, 'null' => true, 'default' => null, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'CREATE_DATE' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => null, 'precision' => null],
        'MODIFY_DATE' => ['type' => 'datetime', 'length' => null, 'null' => true, 'default' => null, 'comment' => null, 'precision' => null],
        'CREATE_OPERATOR_ID' => ['type' => 'string', 'length' => '10', 'null' => true, 'default' => null, 'comment' => null, 'precision' => null, 'fixed' => null, 'collate' => null],
        'MODIFY_OPERATOR_ID' => ['type' => 'string', 'length' => '10', 'null' => true, 'default' => null, 'comment' => null, 'precision' => null, 'fixed' => null, 'collate' => null],
        'CREATE_LOCATION_ID' => ['type' => 'integer', 'length' => null, 'null' => true, 'default' => null, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'MODIFY_LOCATION_ID' => ['type' => 'integer', 'length' => null, 'null' => true, 'default' => null, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'ITEM_SEQUENCE_NUMBER' => ['type' => 'integer', 'length' => null, 'null' => true, 'default' => null, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'HISTORICAL_BOOKINGS' => ['type' => 'integer', 'length' => null, 'null' => true, 'default' => null, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'MEDIA_TYPE_ID' => ['type' => 'integer', 'length' => null, 'null' => true, 'default' => null, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'SHORT_LOAN_CHARGES' => ['type' => 'integer', 'length' => null, 'null' => true, 'default' => null, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'MAGNETIC_MEDIA' => ['type' => 'string', 'length' => '1', 'null' => true, 'default' => '\'N\'', 'comment' => null, 'precision' => null, 'fixed' => null, 'collate' => null],
        'SENSITIZE' => ['type' => 'string', 'length' => '1', 'null' => true, 'default' => '\'Y\'', 'comment' => null, 'precision' => null, 'fixed' => null, 'collate' => null],
        '_indexes' => [
            'ITEM_ITEM_TYPE_IDX' => ['type' => 'index', 'columns' => ['ITEM_TYPE_ID'], 'length' => []],
            'ITEM_TEMPLOC_PERMLOC_IDX' => ['type' => 'index', 'columns' => ['TEMP_LOCATION', 'PERM_LOCATION'], 'length' => []],
        ],
        '_constraints' => [
            'ITEM_IDX' => ['type' => 'unique', 'columns' => ['ITEM_ID'], 'length' => []],
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
                'PERM_LOCATION' => 1,
                'TEMP_LOCATION' => 1,
                'ITEM_TYPE_ID' => 1,
                'TEMP_ITEM_TYPE_ID' => 1,
                'COPY_NUMBER' => 1,
                'ON_RESERVE' => 'L',
                'RESERVE_CHARGES' => 1,
                'PIECES' => 1,
                'PRICE' => 1,
                'SPINE_LABEL' => 'Lorem ipsum dolor sit a',
                'HISTORICAL_CHARGES' => 1,
                'HISTORICAL_BROWSES' => 1,
                'RECALLS_PLACED' => 1,
                'HOLDS_PLACED' => 1,
                'CREATE_DATE' => '2019-04-17 20:40:45',
                'MODIFY_DATE' => '2019-04-17 20:40:45',
                'CREATE_OPERATOR_ID' => 'Lorem ip',
                'MODIFY_OPERATOR_ID' => 'Lorem ip',
                'CREATE_LOCATION_ID' => 1,
                'MODIFY_LOCATION_ID' => 1,
                'ITEM_SEQUENCE_NUMBER' => 1,
                'HISTORICAL_BOOKINGS' => 1,
                'MEDIA_TYPE_ID' => 1,
                'SHORT_LOAN_CHARGES' => 1,
                'MAGNETIC_MEDIA' => 'L',
                'SENSITIZE' => 'L'
            ],
        ];
        parent::init();
    }
}
