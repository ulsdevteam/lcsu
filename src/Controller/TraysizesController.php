<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;
/**
 * Traysizes Controller
 *
 * @property \App\Model\Table\TraysizesTable $Traysizes
 *
 * @method \App\Model\Entity\Traysize[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TraysizesController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $traysizes = $this->paginate($this->Traysizes);

        $this->set(compact('traysizes'));
    }

    /**
     * View method
     *
     * @param string|null $id Traysize id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $traysize = $this->Traysizes->get($id, [
            'contain' => []
        ]);

        $this->set('traysize', $traysize);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $traysize = $this->Traysizes->newEntity();
        if ($this->request->is('post')) {
            $traysize = $this->Traysizes->patchEntity($traysize, $this->request->getData());
            if ($this->Traysizes->save($traysize)) {
                $this->Flash->success(__('The traysize has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The traysize could not be saved. Please, try again.'));
        }
        $this->set(compact('traysize'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Traysize id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $traysize = $this->Traysizes->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $traysize = $this->Traysizes->patchEntity($traysize, $this->request->getData());
            if ($this->Traysizes->save($traysize)) {
                $this->Flash->success(__('The traysize has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The traysize could not be saved. Please, try again.'));
        }
        $this->set(compact('traysize'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Traysize id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $traysize = $this->Traysizes->get($id);
        if ($this->Traysizes->delete($traysize)) {
            $this->Flash->success(__('The traysize has been deleted.'));
        } else {
            $this->Flash->error(__('The traysize could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function listAllTraysizes()
    {
        $this->viewBuilder()->layout(false);
        $traysize = $this->Traysizes->find('all');
        $this->set('test', json_encode($traysize));
    }
}
