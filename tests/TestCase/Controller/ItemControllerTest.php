<?php
namespace App\Test\TestCase\Controller;

use App\Controller\ItemController;
use Cake\TestSuite\IntegrationTestTrait;
use Cake\TestSuite\TestCase;

/**
 * App\Controller\ItemController Test Case
 */
class ItemControllerTest extends TestCase
{
    use IntegrationTestTrait;

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
        'app.RESERVELIST',
        'app.HOLDRECALLITEMS',
        'app.ITEMNOTETYPE',
        'app.LINEITEMSTATUS',
        'app.LINEITEMTYPE',
        'app.MEDIASCHEDULEITEM',
        'app.RESERVELISTITEMS'
    ];

    /**
     * Test index method
     *
     * @return void
     */
    public function testIndex()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test view method
     *
     * @return void
     */
    public function testView()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test add method
     *
     * @return void
     */
    public function testAdd()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test edit method
     *
     * @return void
     */
    public function testEdit()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test delete method
     *
     * @return void
     */
    public function testDelete()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
