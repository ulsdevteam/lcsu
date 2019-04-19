<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * ItemBarcode Controller
 *
 * @property \App\Model\Table\ItemBarcodeTable $ItemBarcode
 *
 * @method \App\Model\Entity\ItemBarcode[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ItemBarcodeController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $itemBarcode = $this->paginate($this->ItemBarcode);

        $this->set(compact('itemBarcode'));
    }

    /**
     * View method
     *
     * @param string|null $id Item Barcode id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $itemBarcode = $this->ItemBarcode->get($id, [
            'contain' => []
        ]);

        $this->set('itemBarcode', $itemBarcode);
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $itemBarcode = $this->ItemBarcode->newEntity();
        if ($this->request->is('post')) {
            $itemBarcode = $this->ItemBarcode->patchEntity($itemBarcode, $this->request->getData());
            if ($this->ItemBarcode->save($itemBarcode)) {
                $this->Flash->success(__('The item barcode has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item barcode could not be saved. Please, try again.'));
        }
        $this->set(compact('itemBarcode'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Item Barcode id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $itemBarcode = $this->ItemBarcode->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $itemBarcode = $this->ItemBarcode->patchEntity($itemBarcode, $this->request->getData());
            if ($this->ItemBarcode->save($itemBarcode)) {
                $this->Flash->success(__('The item barcode has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The item barcode could not be saved. Please, try again.'));
        }
        $this->set(compact('itemBarcode'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Item Barcode id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $itemBarcode = $this->ItemBarcode->get($id);
        if ($this->ItemBarcode->delete($itemBarcode)) {
            $this->Flash->success(__('The item barcode has been deleted.'));
        } else {
            $this->Flash->error(__('The item barcode could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }
}
