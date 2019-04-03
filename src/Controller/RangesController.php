<?php

namespace App\Controller;

use App\Controller\AppController;
use Cake\Event\Event;

/**
 * Ranges Controller
 *
 * @property \App\Model\Table\RangesTable $Ranges
 *
 * @method \App\Model\Entity\Range[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class RangesController extends AppController 
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index() 
    {
        $ranges = $this->paginate($this->Ranges);
        
        $this->set(compact('ranges'));
    }

    /**
     * View method
     *
     * @param string|null $id Range id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null) 
    {
        $range = $this->Ranges->get($id);
        $modules = $this->Ranges->Modules->find('all')->where(['range_id' => $id]);
        $modules = $this->paginate($modules);
        $this->set(compact('range', $range, 'modules'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add() 
    {
        $range = $this->Ranges->newEntity();
        if ($this->request->is('post')) {
            $range = $this->Ranges->patchEntity($range, $this->request->getData());
            if ($this->Ranges->save($range)) {
                $this->Flash->success(__('The range has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The range could not be saved. Please, try again.'));
        }
        $this->set(compact('range'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Range id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null) 
    {
        $range = $this->Ranges->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $range = $this->Ranges->patchEntity($range, $this->request->getData());
            if ($this->Ranges->save($range)) {
                $this->Flash->success(__('The range has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The range could not be saved. Please, try again.'));
        }
        $this->set(compact('range'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Range id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null) 
    {
        $this->request->allowMethod(['post', 'delete']);
        $range = $this->Ranges->get($id);
        if ($this->Ranges->delete($range)) {
            $this->Flash->success(__('The range has been deleted.'));
        } else {
            $this->Flash->error(__('The range could not be deleted. Please, try again.'));
        }

        return $this->redirect($this->referer());
    }

}
