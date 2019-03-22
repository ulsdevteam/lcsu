<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Routing\Router;
use App\Utility\PhpNetworkLprPrinter;
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
            'contain' => ['Status']
        ];

        $filter = $this->request->getQuery('filter');
        switch ($filter) {
            case 'incompleted':
                $this->set( 'trays', $this->paginate($this->Trays->find('all')->where(['Trays.status_id' => 1])));
                break;
            case 'validate':
                $this->set( 'trays', $this->paginate($this->Trays->find('all')->where(['Trays.status_id' => 2])));
                break;
            default:
                $this->set( 'trays', $this->paginate( $this->Trays));
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
        $tray = $this->Trays->get($id, [
            'contain' => []
        ]);

        $books = $this->paginate($this->Trays->Books->find('all')->where(['tray_id' => $id]));
        $status = $this->Trays->Status->find('all')->where(['status_id' => $tray->status_id]);
        $this->set(compact('tray', 'books', 'status'));
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
        $tray = $this->Trays->get($id, [
            'contain' => []
        ]);
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
     *
     * @return \Cake\Http\Response|null Redirects to index.
     */
     public function scanInit()
     {
         $tray = $this->Trays->newEntity();
         if ($this->request->is('post')) {
             $tray = $this->Trays->find('all')->where(['tray_barcode' => $this->request->getData('tray_barcode')])->first();
             
             if (!isset($tray)) {
                $this->Flash->error(__('The tray is not in the database.'));
            } else {
                $tray->modified_user = $this->Auth->user('username');
                if ($this->Trays->save($tray)) {

                    $this->Flash->success(__('The tray has been saved.'));

                    return $this->redirect(['controller' => 'books',
                                            'action' => 'scan',
                                            'tray_id' => $tray->tray_id,
                                            'count' => $this->request->getData()['num_books'],
                                            'id' => 1]);
                }
                $this->Flash->error(__('The tray could not be saved. Please, try again.'));
            }
         }
         $this->set(compact('tray'));
    }

    /**
     * ScanEnd method
     *
     * @return \Cake\Http\Response|null Redirects to index.
     */
    public function scanEnd($id = null) 
    {
        $tray = $this->Trays->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tray = $this->Trays->patchEntity($tray, $this->request->getData());
            // I don't know how to use count(*) here. So, I use toArray() and count() instead.
            $num_books = $this->Trays->Books->find('all', ['limit' => 200])
                    ->where(['tray_id' => $id]);
            if (count($num_books->toArray()) != intval($this->request->getQuery('count'))) {
                $this->Flash->error(__('The tray barcode or the amount of books is wrong.'));
            }
            $tray->status_id = intval($tray->status_id) + 1;
            $tray->modified_user = $this->Auth->user('username');
            if ($this->Trays->save($tray)) {
                return $this->redirectScanInit();
            }
            $this->Flash->error(__('Fail to wrap up this tray.'));
        }
        $this->set(compact('tray'));
    }

    public function redirectScanInit()
    {
        $source = $this->request->getQuery('source');
        if ($source) {
            switch ($source) {
                case 'validate':
                    $this->Flash->success(__('The tray(' . $tray->tray_barcode . ') has been validated.'));
                    break;
                case 'incomplete':
                    $this->Flash->success(__('The tray(' . $tray->tray_barcode . ') has been completed.'));
                    break;
            }
            return $this->redirect(['action' => 'index', 'filter' => $this->request->getQuery('source')]);
        } else {
            return $this->redirect(['action' => 'scanInit']);
        }
    }

    /**
     * ScanInit method
     *
     * @return \Cake\Http\Response|null Redirects to index with filter incompleted.
     */
    public function incompleted($id = null) 
    {
        $tray = $this->Trays->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $tray = $this->Trays->patchEntity($tray, $this->request->getData());
            $tray->modified_user = $this->Auth->user('username');
            $books = $this->Trays->Books->find('all', ['limit' => 200])
                    ->where(['tray_id' => $id]);
            if (count($books->toArray()) > 0) {
                $this->Trays->Books->deleteAll(['tray_id' => $tray->tray_id]);
            }

            if ($this->Trays->save($tray)) {
                $this->Flash->success(__('The books in the tray are been removed.'));
                return $this->redirect(['controller' => 'books',
                            'action' => 'scan',
                            'tray_id' => $tray->tray_id,
                            'count' => $this->request->getData('num_books'),
                            'source' => 'incompleted',
                            'id' => 1]);
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
        $tray = $this->Trays->get($id, [
            'contain' => []
            ]);
        $books = $this->Trays->Books->find('all', ['limit' => 200])
                ->where(['tray_id' => $id]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            if (count($books->toArray()) != $this->request->getData('num_books')) {
                $this->Trays->Books->deleteAll(['tray_id' => $tray->tray_id]);
                $tray->status_id = 1;
                $tray->modified_user = $this->Auth->user('username');
                if ($this->Trays->save($tray)) {
                    return $this->redirect(['controller' => 'books',
                                'action' => 'scan',
                                'tray_id' => $tray->tray_id,
                                'count' => $this->request->getData('num_books'),
                                'id' => 1]);
                }
            } else if ($tray->tray_barcode != $this->request->getData('tray_barcode')) {
                $this->Flash->error(__("The tray barcode doesn't match."));
            } else {
                return $this->redirect(['controller' => 'books',
                            'action' => 'scanList',
                            'tray_id' => $tray->tray_id,
                            'id' => 1, //current amount
                            'count' => $this->request->getData('num_books')]);
            }
        }
        $amount = count($books->toArray());
        $this->set(compact('tray', 'amount'));
    }

    /**
     * Export flat file
     * setsebool httpd_can_network_connect=1
     * format:  Tray address, space, short date, tab, item barcode, tab, long date, tab, constant “pittlcsu”
     * @example: R16-M13-S03-T01 03/04/19   31735064253499	2019/03/04 09:01:42	pittlcsu 
     * @see https://book.cakephp.org/3.0/en/controllers/request-response.html#sending-a-string-as-file
     * @param string|null $id tray id.
     */
    public function export($id = null)
    {
        $tray = $this->Trays->get($id, [
            'contain' => []
        ]);
        $books = $this->Trays->Books->find('all')->where(['tray_id' => $tray->tray_id]);
        
        $content = '';
        foreach ($books as $book) {
            $content .= $tray->tray_barcode.' '.date('m/d/y')."\t".$book->book_barcode."\t".date('Y/m/d H:i:s')."\t".'pittlcsu'."\r\n";
        }
        $response = $this->response;
        // Inject string content into response body (3.4.0+)
        $response = $response->withStringBody($content);
        $response = $response->withType('txt');
        $response = $response->withDownload($tray->tray_barcode.'_'.date('Y-m-d').'.txt');
        // Update tray status
        if ($tray->status_id == 3) {
            $tray->status_id = 4;
            $this->Trays->save($tray);
        }
        // Refresh the page
        $response = $response->withLocation(Router::url(['controller' => 'shelves', 'action' => 'view', $tray->shelf_id]));
        return $response;
    }
    
    /**
     * Print Single tray Label
     * 
     * @param string|null $id tray id.
     *      */
    public function printLabel($id = null) 
    {
        $tray = $this->Trays->get($id, [
            'contain' => []
        ]);

        $lpr = new PhpNetworkLprPrinter();
        if ($lpr) {
            $result = $lpr->printTrayLabel($tray->tray_barcode);
            if ($result) {
                $this->Flash->error(__($result));
            } else {
                $this->Flash->success(__("Label: ".$tray->tray_barcode));
            }
        }
        return $this->redirect(['controller' => 'Trays', 'action' => 'view', $tray->tray_id]);
    }
}
