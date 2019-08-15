<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Utility\PhpNetworkLprPrinter;
use Cake\Core\Configure;

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
            'contain' => ['Traysizes'],
            'order' => ['Shelves.shelf_barcode' => 'ASC']
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
        $shelf = $this->Shelves->get($id, ['contain' => ['Traysizes']]);
        $trays = $this->paginate($this->Shelves->Trays->find('all', ['order' => ['tray_title' => 'ASC']])->where(['shelf_id' => $id])->contain(['Status']));
        $this->set(compact('shelf', 'trays'));
    }

    /**
     * Add method
     *
     * @see https://book.cakephp.org/3.0/en/controllers/components/security.html
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
        $modules = $this->Shelves->Modules->find('list', ['keyField' => 'module_id','valueField' => 'module_option'])
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
        $shelf = $this->Shelves->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $shelf = $this->Shelves->patchEntity($shelf, $this->request->getData());
            if ($this->Shelves->save($shelf)) {
                $this->Flash->success(__('The shelf has been updated.'));

                return $this->redirect(['action' => 'view', $id]);
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
    
    /**
     * Print Single shelf Label
     * 
     * @param string|null $id shelf id.
     *      */
    public function printLabel($id = null) 
    {
        if ($id) {
            $shelf = $this->Shelves->get($id);
            $lpr = new PhpNetworkLprPrinter(Configure::read('HOST'), Configure::read('PORT'));
            if ($lpr) {
                $result = $lpr->printShelfLabel($shelf->shelf_barcode);
                if (!$result) {
                    $this->Flash->error(__('Error').": ".$lpr->getErrStr());
                } else {
                    $this->Flash->success(__('The label is printed out successfully.'));
                }
            } else {
                $this->Flash->error(__("Cannot connect to printer."));
            }
            return $this->redirect(['action' => 'view', $shelf->shelf_id]);
        }
        $this->Flash->error('The shelf id is missing');
        return $this->redirect($this->referer());
    }
    
    /**
     * Print Tray Labels
     * 
     * @param string|null $id shelf id.
     *      */
    public function printLabels($id = null) 
    {
        if ($id) {
            $shelf = $this->Shelves->get($id);
            $trays = $this->Shelves->Trays->find('all', ['order' => ['tray_title' => 'DESC']])->where(['shelf_id' => $id]);
            $lpr = new PhpNetworkLprPrinter(Configure::read('HOST'), Configure::read('PORT'));
            if ($lpr) {
                foreach ($trays as $tray) {
                    $result = $lpr->printTrayLabel($tray->tray_barcode);
                    if (!$result) {
                        $this->Flash->error(__('Error').": ".$lpr->getErrStr());
                        return $this->redirect(['action' => 'view', $shelf->shelf_id]);
                    }
                }
                $this->Flash->success(__('All labels are printed out successfully.'));
            } else {
                $this->Flash->error(__("Cannot connect to printer."));
            }
            return $this->redirect(['action' => 'view', $shelf->shelf_id]);
        }
        $this->Flash->error(__('The shelf id is missing.'));
        return $this->redirect($this->referer());
    }
    
    /**
     * findAvailable method
     *
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function findAvailable()
    {
        $traysizes = $this->Shelves->Traysizes->find('list',
                                                    ['keyField' => 'traysize_id','valueField' => 'traysize_option',
                                                    'limit' => 200]);
        if ($this->request->getQuery('traysizes')) {
            $traysize = $this->Shelves->Traysizes->get( $this->request->getQuery('traysizes'));
        } else {
            $traysize = $this->Shelves->Traysizes->find('all')->first();
        }
        $shelves = $this->paginate($this->Shelves->find()->contain(['Traysizes'])->where(['Shelves.shelf_height' => $traysize->shelf_height, 'Shelves.tray_category' => $traysize->tray_category])->notMatching('Trays'));
        $this->set(compact('traysizes', 'shelves', 'traysize'));
    }
    
    /**
     * Allocate method
     * Assign traysize and create new trays by traysizes.num_trays for a shelf
     *
     * @param string|null $id $shelf id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function allocate($id = null) 
    {
        $shelf = $this->Shelves->get($id);
        $check_amount = $this->Shelves->Trays->find('all')->where(['shelf_id' => $id])->count();
        // Update traysize, create equal amount of trays, and redirect to view page
        if ($this->request->getQuery('traysize_id') && $check_amount == 0) {
             $traysize = $this->Shelves->Traysizes->find('all')->where(['traysize_id' => $this->request->getQuery('traysize_id')])->first();
            // Update traysize
            $shelf->traysize_id = $traysize->traysize_id;
            $shelf->tray_category = $traysize->tray_category;
            $this->Shelves->save($shelf);
            // Generate new trays
            for ( $i = 1 ; $i <= intVal($traysize->num_trays) ; $i++) {
                $tray = $this->Shelves->Trays->newEntity(['tray_barcode' => $shelf->shelf_barcode."-T".sprintf("%02d", $i), 'modified_user' => $this->Auth->user('username'), 'shelf_id' => $shelf->shelf_id]);
                $tray->created = date("Y-m-d H:i:s");
                $tray->tray_title = 'T'.sprintf("%02d", $i);
                $this->Shelves->Trays->save($tray);
            }
            $this->Flash->success(__('Created {0} trays successfully.', $traysize->num_trays));
        } else {
            $this->Flash->error(__('Fail to allocate new trays.'));
        }

        return $this->redirect(['action' => 'view', $id]);
    }
}
