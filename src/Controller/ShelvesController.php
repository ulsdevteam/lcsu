<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Shelves Controller
 *
 * @property \App\Model\Table\ShelvesTable $Shelves
 *
 * @method \App\Model\Entity\Shelf[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ShelvesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Traysizes']
        ];
        $this->set( 'shelves', $this->paginate( $this->Shelves));
    }

    /**
     * View method
     *
     * @param string|null $id Shelf id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $shelf = $this->Shelves->get($id, [
            'contain' => []
        ]);
        $module = $this->Shelves->Modules->get($shelf->module_id, [
            'contain' => []
        ]);
        $trays = $this->paginate($this->Shelves->Trays->find('all')->where(['shelf_id' => $id]));
        $traysize = $this->Shelves->Traysizes->find()->where(['traysize_id' => $shelf->traysize_id])->first();
        $this->set(compact('shelf', 'module', 'trays', 'traysize'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $shelf = $this->Shelves->newEntity();
        if ($this->request->is('post')) {
            $shelf = $this->Shelves->patchEntity($shelf, $this->request->getData());
            $module_addr = $this->Shelves->Modules->find('all')
                                              ->select(['Ranges.range_title', 'Modules.module_id', 'Modules.module_title'])
                                              ->where(['module_id' => $shelf->module_id])
                                              ->contain(['Ranges'])
                                              ->first();
            $shelf->shelf_barcode = $module_addr->module_option.'-'.$shelf->shelf_title;
            if ($this->Shelves->save($shelf)) {
                $this->Flash->success(__('The shelf has been saved.'));

                if ($this->request->getQuery('module_id')) {
                    return $this->redirect(['controller' => 'Modules', 'action' => 'view/'.$this->request->getData('module_id')]);
                } else {
                    return $this->redirect(['action' => 'index']);
                }
            }
            $this->Flash->error(__('The shelf could not be saved. Please, try again.'));
        }
        $modules = $this->Shelves->Modules->find('list',
                                                    ['keyField' => 'module_id','valueField' => 'module_option'])
                                          ->select(['Ranges.range_title', 'Modules.module_id', 'Modules.module_title'])
                                          ->contain(['Ranges']);
        $modules = $modules->toArray();
        $traysizes = $this->Shelves->Traysizes->find('list',
                                                    ['keyField' => 'traysize_id','valueField' => 'traysize_option',
                                                    'limit' => 200]);
        $this->set(compact('shelf', 'modules', 'traysizes'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Shelf id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $shelf = $this->Shelves->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $shelf = $this->Shelves->patchEntity($shelf, $this->request->getData());
            if ($this->Shelves->save($shelf)) {
                $this->Flash->success(__('The shelf has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The shelf could not be saved. Please, try again.'));
        }
        $modules = $this->Shelves->Modules->find('list',
                                                    ['keyField' => 'module_id','valueField' => 'module_option'])
                                          ->select(['Ranges.range_title', 'Modules.module_id', 'Modules.module_title'])
                                          ->contain(['Ranges']);
        $modules = $modules->toArray();
        $this->set(compact('shelf', 'modules'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Shelf id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $shelf = $this->Shelves->get($id);
        if ($this->Shelves->delete($shelf)) {
            $this->Flash->success(__('The shelf has been deleted.'));
        } else {
            $this->Flash->error(__('The shelf could not be deleted. Please, try again.'));
        }

        return $this->redirect($this->referer());
    }
}
