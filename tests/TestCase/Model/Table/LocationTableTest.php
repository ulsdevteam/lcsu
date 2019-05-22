<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\LocationTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\LocationTable Test Case
 */
class LocationTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\LocationTable
     */
    public $Location;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.Location',
        'app.LEDGER',
        'app.REQUESTGROUP',
        'app.SORTGROUP'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('Location') ? [] : ['className' => LocationTable::class];
        $this->Location = TableRegistry::getTableLocator()->get('Location', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->Location);

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
