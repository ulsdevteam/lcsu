<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ItemTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ItemTable Test Case
 */
class ItemTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ItemTable
     */
    public $Item;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Item',
        'app.HOLDRECALL',
        'app.NOTETYPE',
        'app.ITEMSTATUS',
        'app.ITEMTYPE',
        'app.MEDIASCHEDULE',
        'app.RESERVELIST'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Item') ? [] : ['className' => ItemTable::class];
        $this->Item = TableRegistry::getTableLocator()->get('Item', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Item);

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
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
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
