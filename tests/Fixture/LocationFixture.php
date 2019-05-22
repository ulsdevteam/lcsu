<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * LocationFixture
 */
class LocationFixture extends TestFixture
{
    /**
     * Table name
     *
     * @var string
     */
    public $table = 'LOCATION';
    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'LOCATION_ID' => ['type' => 'integer', 'length' => null, 'null' => true, 'default' => null, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'LOCATION_CODE' => ['type' => 'string', 'length' => '10', 'null' => true, 'default' => null, 'comment' => null, 'precision' => null, 'fixed' => null, 'collate' => null],
        'LOCATION_NAME' => ['type' => 'string', 'length' => '25', 'null' => true, 'default' => null, 'comment' => null, 'precision' => null, 'fixed' => null, 'collate' => null],
        'LOCATION_DISPLAY_NAME' => ['type' => 'string', 'length' => '60', 'null' => true, 'default' => null, 'comment' => null, 'precision' => null, 'fixed' => null, 'collate' => null],
        'LOCATION_SPINE_LABEL' => ['type' => 'string', 'length' => '25', 'null' => true, 'default' => null, 'comment' => null, 'precision' => null, 'fixed' => null, 'collate' => null],
        'LOCATION_OPAC' => ['type' => 'string', 'length' => '1', 'null' => true, 'default' => null, 'comment' => null, 'precision' => null, 'fixed' => null, 'collate' => null],
        'SUPPRESS_IN_OPAC' => ['type' => 'string', 'length' => '1', 'null' => true, 'default' => null, 'comment' => null, 'precision' => null, 'fixed' => null, 'collate' => null],
        'LIBRARY_ID' => ['type' => 'integer', 'length' => null, 'null' => true, 'default' => null, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        'MFHD_COUNT' => ['type' => 'integer', 'length' => null, 'null' => true, 'default' => null, 'comment' => null, 'precision' => null, 'unsigned' => null, 'autoIncrement' => null],
        '_constraints' => [
            'LOCATION_LOC_ID_IDX' => ['type' => 'unique', 'columns' => ['LOCATION_ID'], 'length' => []],
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
                'LOCATION_ID' => 1,
                'LOCATION_CODE' => 'Lorem ip',
                'LOCATION_NAME' => 'Lorem ipsum dolor sit a',
                'LOCATION_DISPLAY_NAME' => 'Lorem ipsum dolor sit amet',
                'LOCATION_SPINE_LABEL' => 'Lorem ipsum dolor sit a',
                'LOCATION_OPAC' => 'L',
                'SUPPRESS_IN_OPAC' => 'L',
                'LIBRARY_ID' => 1,
                'MFHD_COUNT' => 1
            ],
        ];
        parent::init();
    }
}
