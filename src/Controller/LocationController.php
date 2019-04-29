<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Location Controller
 *
 * @property \App\Model\Table\LocationTable $Location
 *
 * @method \App\Model\Entity\Location[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class LocationController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $location = $this->paginate($this->Location);

        $this->set(compact('location'));
    }

    /**
     * View method
     *
     * @param string|null $id Location id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $location = $this->Location->get($id, [
            'contain' => ['LEDGER', 'REQUESTGROUP', 'SORTGROUP']
        ]);

        $this->set('location', $location);
    }
}
