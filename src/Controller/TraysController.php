<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Routing\Router;
use App\Utility\PhpNetworkLprPrinter;
use Cake\Core\Configure;
/**
 * Trays Controller
 *
 * @property \App\Model\Table\TraysTable $Trays
 *
 * @method \App\Model\Entity\Tray[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class TraysController extends AppController
{    
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Status'],
            'order' => ['Trays.modified' => 'DESC']
        ];

        $filter = $this->request->getQuery('filter');
        switch ($filter) {
            case 'incompleted':
                $this->set('trays', $this->paginate($this->Trays->find('all')->where(['Trays.status_id' => Configure::read('Incompleted')])));
                break;
            case 'validate':
                $this->set('trays', $this->paginate($this->Trays->find('all')->where(['Trays.status_id' => Configure::read('Validate')])));
                break;
            default:
                $this->set('trays', $this->paginate($this->Trays));
                break;
        }
    }

    /**
     * View method
     *
     * @param string|null $id Tray id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $tray = $this->Trays->get($id, ['contain' => ['Status']]);
        $this->paginate = ['order' => ['Books.book_barcode' => 'ASC']];
        $books = $this->paginate($this->Trays->Books->find('all')->where(['tray_id' => $id]));
        $this->set(compact('tray', 'books'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $tray = $this->Trays->newEntity();
        if ($this->request->is('post')) {
            $tray = $this->Trays->patchEntity($tray, $this->request->getData());
            $tray->modified_user = $this->Auth->user('username');
            $tray->created = date("Y-m-d H:i:s");
            $tray->shelf_id = $this->request->getQuery('shelf_id');
            $shelf_addr = $this->Trays->Shelves->find('all')
                                                    ->where(['shelf_id' => $this->request->getQuery('shelf_id')])
                                                    ->contain(['Modules'])
                                                    ->first();
            $tray->tray_barcode = $shelf_addr->shelf_barcode.'-'.$tray->tray_title;
            if ($this->Trays->save($tray)) {
                $this->Flash->success(__('The tray has been saved.'));

                return $this->redirect($this->referer());
            }
            $this->Flash->error(__('The tray could not be saved. Please, try again.'));
        }
        $shelves = $this->Trays->Shelves->find('list',
                                                ['keyField' => 'shelf_id','valueField' => 'shelf_barcode',
                                                'limit' => 1])
                                                ->select(['Modules.module_title', 'shelf_id', 'shelf_barcode'])
                                                ->where(['shelf_id' => $this->request->getQuery('shelf_id')])
                                                ->contain(['Modules']);
        $shelves = $shelves->toArray();
        $this->set(compact('tray', 'shelves'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Tray id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $tray = $this->Trays->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tray = $this->Trays->patchEntity($tray, $this->request->getData());
            $tray->modified_user = $this->Auth->user('username');
            if ($this->Trays->save($tray)) {
                $this->Flash->success(__('The tray has been saved.'));
                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The tray could not be saved. Please, try again.'));
        }
        $shelves = $this->Trays->Shelves->find('list',
                                                ['keyField' => 'shelf_id','valueField' => 'shelf_barcode'])
                                                ->select(['Modules.module_title', 'shelf_id', 'shelf_barcode'])
                                                ->contain(['Modules']);
        $shelves = $shelves->toArray();
        $this->set(compact('tray', 'shelves'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Tray id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $tray = $this->Trays->get($id);
        $this->Trays->Books->deleteAll(['tray_id' => $tray->tray_id]);
        if ($this->Trays->delete($tray)) {
            $this->Flash->success(__('The tray has been deleted.'));
        } else {
            $this->Flash->error(__('The tray could not be deleted. Please, try again.'));
        }
        if (strpos($this->referer(), 'view') !== false && strpos($this->referer(), 'trays') !== false) {
            return $this->redirect(['action' => 'index']);
        }
        return $this->redirect($this->referer());
    }

    /**
     * ScanInit method
     * @var $tray_id Optional tray id
     * @return \Cake\Http\Response|null Redirects to index.
     */
     public function scanInit($tray_id = null)
     {
         $progress = $this->Trays->books->find('all')->where(['tray_id' => $tray_id])->count();
        if ($tray_id) {
            // Allow uncaught 404 on lookup failure
            $tray = $this->Trays->get($tray_id);
        } else {
            $tray = $this->Trays->newEntity();
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            echo "progess: ".$progress."   num: ". $this->request->getData('num_books');
            $tray = $this->Trays->find('all')->where(['tray_barcode' => $this->request->getData('tray_barcode')])->first();
            if (!isset($tray)) {
                $this->Flash->error(__('The tray is not in the database.'));
            } else if ($tray->status_id != Configure::read('Incompleted')) {
                $this->Flash->error(__('The tray is already in process. Please, try a different tray.'));
            } else {
                $tray->modified_user = $this->Auth->user('username');
                if($this->request->getData('is_restart')){
                    $this->Trays->Books->deleteAll(['tray_id' => $tray->tray_id]);
                }

                if ($this->Trays->save($tray)) {
                    $this->Flash->success(__('The tray has been saved.'));
                    if ($progress == $this->request->getData('num_books') && !$this->request->getData('is_restart')) {
                        // Wrap up the process
                        return $this->redirect(['controller' => 'trays',
                                                'action' => 'scanEnd',
                                                $tray_id,
                                                'count' => $progress]);
                    } else {
                        return $this->redirect(['controller' => 'books',
                                            'action' => 'scan',
                                            'count' => $this->request->getData()['num_books'],
                                            $tray->tray_id]);
                    }
                }
                $this->Flash->error(__('The tray could not be saved. Please, try again.'));
            }
         }
         $this->set(compact('tray', 'progress'));
    }

    /**
     * ScanEnd method
     *
     * @param $id string Tray id
     * @return \Cake\Http\Response|null Redirects to index.
     */
    public function scanEnd($id) 
    {
        $tray = $this->Trays->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            if ($tray->tray_barcode !== $this->request->getData('tray_barcode')) {
                $this->Flash->error(__('The tray barcode does not match.'));
            } else {
                $num_books = $this->Trays->Books->find('all', ['limit' => 200])
                        ->where(['tray_id' => $id])->count();
                if ($num_books != intval($this->request->getQuery('count'))) {
                    $this->Flash->error(__('The tray barcode or the amount of books is wrong.'));
                }
                $tray->status_id = intval($tray->status_id) + 1;
                $tray->modified_user = $this->Auth->user('username');
                if ($this->Trays->save($tray)) {
                    return $this->redirectScanInit($tray);
                }
                $this->Flash->error(__('Fail to wrap up this tray.'));
            }
        }
        $this->set(compact('tray'));
    }

    /**
     * Redirect to scan initial method
     * 
     * @param object $tray single tray
     */
    public function redirectScanInit($tray)
    {
        $source = $this->request->getQuery('source');
        if ($source) {
            switch ($source) {
                case 'validate':
                    $this->Flash->success(__('The tray # {0} has been validated.', $tray->tray_barcode));
                    break;
                case 'incomplete':
                    $this->Flash->success(__('The tray # {0} has been completed.', $tray->tray_barcode));
                    break;
            }
            return $this->redirect(['action' => 'index', 'filter' => $this->request->getQuery('source')]);
        } else {
            return $this->redirect(['action' => 'scanInit']);
        }
    }

    /**
     * ScanInit method
     * TODO: move delete logic into scan-init
     * @return \Cake\Http\Response|null Redirects to index with filter incompleted.
     */
    public function incompleted($id = null) 
    {
        $tray = $this->Trays->get($id);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tray = $this->Trays->patchEntity($tray, $this->request->getData());
            $tray->modified_user = $this->Auth->user('username');
            $count_books = $this->Trays->Books->find('all', ['limit' => 200])
                    ->where(['tray_id' => $id])->count();
            if ($count_books > 0) {
                $this->Trays->Books->deleteAll(['tray_id' => $tray->tray_id]);
            }

            if ($this->Trays->save($tray)) {
                $this->Flash->success(__('The books in the tray are been removed.'));
                return $this->redirect(['controller' => 'books',
                            'action' => 'scan',
                            'count' => $this->request->getData('num_books'),
                            'source' => 'incompleted',
                            'id' => 1,
                            $tray->tray_id]);
            }
            $this->Flash->error(__('Please, try again.'));
        }
        $this->set(compact('tray'));
    }

    /**
     *
     */
    public function validate($id=null) 
    {
        $tray = $this->Trays->get($id);
        if ($tray->status_id != Configure::read('Validate')) {
            $this->Flash->error(__('This tray cannot be validated.'));
            return $this->redirect(['action' => 'index', 'filter' => 'validate']);
        }
        $count_books = $this->Trays->Books->find('all', ['limit' => 200])
                ->where(['tray_id' => $id])->count();
        if ($this->request->is(['patch', 'post', 'put'])) {
            if ($count_books != $this->request->getData('num_books')) {
                $this->Trays->Books->deleteAll(['tray_id' => $tray->tray_id]);
                $tray->status_id = Configure::read('Incompleted');
                $tray->modified_user = $this->Auth->user('username');
                if ($this->Trays->save($tray)) {
                    return $this->redirect(['controller' => 'books',
                                'action' => 'scan',
                                'count' => $this->request->getData('num_books'),
                                'id' => 1,
                                $tray->tray_id]);
                }
            } else if ($tray->tray_barcode != $this->request->getData('tray_barcode')) {
                $this->Flash->error(__("The tray barcode doesn't match."));
            } else {
                return $this->redirect([
                            'action' => 'scanList',
                            $tray->tray_id]);
            }
        }
        $amount = $count_books;
        $this->set(compact('tray', 'amount'));
    }

    /**
     * Scan list method
     *
     * @param string $id Tray id
     */
    public function scanList($id)
    {
        $tray = $this->Trays->get($id);
        if ($tray->status_id != Configure::read('Validate')) {
            $this->Flash->error(__('This tray cannot be validated.'));
            return $this->redirect(['action' => 'index', 'filter' => 'validate']);
        }
        $bookList = $this->Trays->Books->find('all', ['limit' => 200])
                                        ->where(['tray_id' => $id]);
        $this->set(compact('tray', 'bookList'));
    }
    
    /**
     * Export flat file for all completed tray
     * format:  Tray address, space, short date, tab, item barcode, tab, long date, tab, constant “pittlcsu”
     * @example: R16-M13-S03-T01 03/04/19   31735064253499	2019/03/04 09:01:42	pittlcsu 
     * @see https://book.cakephp.org/3.0/en/controllers/request-response.html#sending-a-string-as-file
     */
    public function export($testonly = false)
    {
        $trays = $this->Trays->find('all')->contain(['Books'])->where(['Trays.status_id' => Configure::read('Completed')]);
        $this->Flash->success(json_encode($trays));
        if ($trays) {
            $content = '';
            foreach ($trays as $tray) {
                foreach ($tray->books as $book) {
                    $content .= $tray->tray_barcode.' '.date('m/d/Y', strtotime($tray->created))."\t".$book->book_barcode."\t".date('Y/m/d H:i:s', strtotime($tray->created))."\t".'pittlcsu'."\r\n";
                }
                if (!$testonly) {
                    $tray->status_id = Configure::read('Exported');
                    $this->Trays->save($tray);
                }
            }
        }
        $response = $this->response;
        // Inject string content into response body (3.4.0+)
        $response = $response->withStringBody($content);
        $response = $response->withType('txt');
        $response = $response->withDownload(date('Y-m-d').'.txt');
        return $response;
    }
    
    /**
     * Print Single tray Label
     * setsebool httpd_can_network_connect=1
     * @param string|null $id tray id.
     */
    public function printLabel($id = null) 
    {
        if ($id) {
            $tray = $this->Trays->get($id);
            $lpr = new PhpNetworkLprPrinter(Configure::read('HOST'), Configure::read('PORT'));
            if ($lpr) {
                $result = $lpr->printTrayLabel($tray->tray_barcode);
                if (!$result) {
                    $this->Flash->error(__('Error').": ".$lpr->getErrStr());
                } else {
                    $this->Flash->success(__('The label is printed out successfully.'));
                }
            } else {
                $this->Flash->error(__("Cannot connect to printer."));
            }
            return $this->redirect(['controller' => 'Trays', 'action' => 'view', $tray->tray_id]);
        }
        $this->Flash->error(__('The tray id is missing.'));
        return $this->redirect($this->referer());
    }
}
