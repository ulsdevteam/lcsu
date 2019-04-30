<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ItemBarcodeTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ItemBarcodeTable Test Case
 */
class ItemBarcodeTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ItemBarcodeTable
     */
    public $ItemBarcode;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ItemBarcode'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ItemBarcode') ? [] : ['className' => ItemBarcodeTable::class];
        $this->ItemBarcode = TableRegistry::getTableLocator()->get('ItemBarcode', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ItemBarcode);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test defaultConnectionName method
     *
     * @return void
     */
    public function testDefaultConnectionName()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
