<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Item Controller
 *
 * @property \App\Model\Table\ItemTable $Item
 *
 * @method \App\Model\Entity\Item[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ItemController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $item = $this->paginate($this->Item);

        $this->set(compact('item'));
    }

    /**
     * View method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $item = $this->Item->get($id, [
            'contain' => ['HOLDRECALL', 'NOTETYPE', 'ITEMSTATUS', 'ITEMTYPE', 'MEDIASCHEDULE', 'RESERVELIST']
        ]);

        $this->set('item', $item);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $item = $this->Item->newEntity();
        if ($this->request->is('post')) {
            $item = $this->Item->patchEntity($item, $this->request->getData());
            if ($this->Item->save($item)) {
                $this->Flash->success(__('The item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item could not be saved. Please, try again.'));
        }
        $hOLDRECALL = $this->Item->HOLDRECALL->find('list', ['limit' => 200]);
        $nOTETYPE = $this->Item->NOTETYPE->find('list', ['limit' => 200]);
        $iTEMSTATUS = $this->Item->ITEMSTATUS->find('list', ['limit' => 200]);
        $iTEMTYPE = $this->Item->ITEMTYPE->find('list', ['limit' => 200]);
        $mEDIASCHEDULE = $this->Item->MEDIASCHEDULE->find('list', ['limit' => 200]);
        $rESERVELIST = $this->Item->RESERVELIST->find('list', ['limit' => 200]);
        $this->set(compact('item', 'hOLDRECALL', 'nOTETYPE', 'iTEMSTATUS', 'iTEMTYPE', 'mEDIASCHEDULE', 'rESERVELIST'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $item = $this->Item->get($id, [
            'contain' => ['HOLDRECALL', 'NOTETYPE', 'ITEMSTATUS', 'ITEMTYPE', 'MEDIASCHEDULE', 'RESERVELIST']
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $item = $this->Item->patchEntity($item, $this->request->getData());
            if ($this->Item->save($item)) {
                $this->Flash->success(__('The item has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item could not be saved. Please, try again.'));
        }
        $hOLDRECALL = $this->Item->HOLDRECALL->find('list', ['limit' => 200]);
        $nOTETYPE = $this->Item->NOTETYPE->find('list', ['limit' => 200]);
        $iTEMSTATUS = $this->Item->ITEMSTATUS->find('list', ['limit' => 200]);
        $iTEMTYPE = $this->Item->ITEMTYPE->find('list', ['limit' => 200]);
        $mEDIASCHEDULE = $this->Item->MEDIASCHEDULE->find('list', ['limit' => 200]);
        $rESERVELIST = $this->Item->RESERVELIST->find('list', ['limit' => 200]);
        $this->set(compact('item', 'hOLDRECALL', 'nOTETYPE', 'iTEMSTATUS', 'iTEMTYPE', 'mEDIASCHEDULE', 'rESERVELIST'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $item = $this->Item->get($id);
        if ($this->Item->delete($item)) {
            $this->Flash->success(__('The item has been deleted.'));
        } else {
            $this->Flash->error(__('The item could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
