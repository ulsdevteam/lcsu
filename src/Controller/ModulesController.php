<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Utility\PhpNetworkLprPrinter;

/**
 * Modules Controller
 *
 * @property \App\Model\Table\ModulesTable $Modules
 *
 * @method \App\Model\Entity\Module[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ModulesController extends AppController
{

    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate =  ['order' => ['Modules.module_title' => 'ASC']];
        $modules = $this->paginate($this->Modules);

        $this->set(compact('modules'));
    }

    /**
     * View method
     *
     * @param string|null $id Module id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $module = $this->Modules->get($id);
        $range = $this->Modules->Ranges->get($module->range_id);
        $this->paginate =  ['order' => ['Shelves.shelf_barcode' => 'ASC']];
        $shelves = $this->paginate($this->Modules->Shelves->find('all')->where(['module_id' => $id]));
        
        $this->set(compact('module', 'range', 'shelves'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $module = $this->Modules->newEntity();
        if ($this->request->is('post')) {
            $module = $this->Modules->patchEntity($module, $this->request->getData());
            // echo json_encode($this->request->getData());
            if ($this->Modules->save($module)) {
                $this->Flash->success(__('The module has been saved.'));
                if ($this->request->getQuery('range_id')) {
                    return $this->redirect(['controller' => 'Ranges', 'action' => 'view/'.$this->request->getData('range_id')]);
                } else {
                    return $this->redirect(['action' => 'index']);
                }
            }
            $this->Flash->error(__('The module could not be saved. Please, try again.'));
        }
        $ranges = $this->Modules->Ranges->find('list',
                                                    ['keyField' => 'range_id','valueField' => 'range_title']);
        $ranges = $ranges->toArray();
        $this->set(compact('module', 'ranges'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Module id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $module = $this->Modules->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $module = $this->Modules->patchEntity($module, $this->request->getData());
            if ($this->Modules->save($module)) {
                $this->Flash->success(__('The module has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The module could not be saved. Please, try again.'));
        }
        $ranges = $this->Modules->Ranges->find('list',
                                                    ['keyField' => 'range_id','valueField' => 'range_title']);
        $ranges = $ranges->toArray();
        $this->set(compact('module', 'ranges'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Module id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $module = $this->Modules->get($id);
        if ($this->Modules->delete($module)) {
            $this->Flash->success(__('The module has been deleted.'));
        } else {
            $this->Flash->error(__('The module could not be deleted. Please, try again.'));
        }

        return $this->redirect($this->referer());
    }
    
    /**
     * Print shelf Labels
     * 
     * @param string|null $id module id.
     *      */
    public function printLabels($id = null) 
    {
        if ($id) {
            $module = $this->Modules->get($id);
            $shelves = $this->Modules->Shelves->find('all', ['order' => ['shelf_title' => 'DESC']])->where(['module_id' => $id]);
            $lpr = new PhpNetworkLprPrinter();

            if ($lpr) {
                foreach ($shelves as $shelf) {
                    $errMsg = $lpr->printShelfLabel($shelf->shelf_barcode);
                    if ($errMsg) {
                        $thie->Flash->error($errMsg);
                        return $this->redirect(['action' => 'view', $module->module_id]);
                    }
                }            
                $this->Flash->success(__('All labels are printed out successfully.'));
            } else {
                $this->Flash->error(__("Cannot connect to printer."));
            }
            return $this->redirect(['action' => 'view', $module->module_id]);
        }
        $this->Flash->error(__('The module id is missing.'));
        return $this->redirect($this->referer());
    }
}
