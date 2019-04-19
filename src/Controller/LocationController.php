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

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $location = $this->Location->newEntity();
        if ($this->request->is('post')) {
            $location = $this->Location->patchEntity($location, $this->request->getData());
            if ($this->Location->save($location)) {
                $this->Flash->success(__('The location has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The location could not be saved. Please, try again.'));
        }
        $lEDGER = $this->Location->LEDGER->find('list', ['limit' => 200]);
        $rEQUESTGROUP = $this->Location->REQUESTGROUP->find('list', ['limit' => 200]);
        $sORTGROUP = $this->Location->SORTGROUP->find('list', ['limit' => 200]);
        $this->set(compact('location', 'lEDGER', 'rEQUESTGROUP', 'sORTGROUP'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Location id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $location = $this->Location->get($id, [
            'contain' => ['LEDGER', 'REQUESTGROUP', 'SORTGROUP']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $location = $this->Location->patchEntity($location, $this->request->getData());
            if ($this->Location->save($location)) {
                $this->Flash->success(__('The location has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The location could not be saved. Please, try again.'));
        }
        $lEDGER = $this->Location->LEDGER->find('list', ['limit' => 200]);
        $rEQUESTGROUP = $this->Location->REQUESTGROUP->find('list', ['limit' => 200]);
        $sORTGROUP = $this->Location->SORTGROUP->find('list', ['limit' => 200]);
        $this->set(compact('location', 'lEDGER', 'rEQUESTGROUP', 'sORTGROUP'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Location id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $location = $this->Location->get($id);
        if ($this->Location->delete($location)) {
            $this->Flash->success(__('The location has been deleted.'));
        } else {
            $this->Flash->error(__('The location could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
