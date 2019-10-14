<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ItemStatusTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ItemStatusTable Test Case
 */
class ItemStatusTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ItemStatusTable
     */
    public $ItemStatus;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.ItemStatus'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('ItemStatus') ? [] : ['className' => ItemStatusTable::class];
        $this->ItemStatus = TableRegistry::getTableLocator()->get('ItemStatus', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->ItemStatus);

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
