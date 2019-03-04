<?php
namespace App\Controller;

use App\Controller\AppController;
use App\Controller\Router;
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
            $tray->modified_user = env('REMOTE_USER', true);
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
            $tray->modified_user = env('REMOTE_USER', true);
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
        return $this->redirect(['controller' => 'ranges', 'action' => 'index']);
        // return $this->redirect($this->referer());
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
             $tray = $this->Trays->patchEntity($tray, $this->request->getData());
             $tray->modified_user = env('REMOTE_USER', true);
             $segs = explode("-", $tray->tray_barcode);
             $tray->tray_title = $segs[3];
             $shelf = $this->Trays->Shelves->find('all')
                                                    ->select(['shelf_id'])
                                                    ->where(['shelf_barcode' => implode('-',array_slice($segs, 0, 3))])
                                                    ->first();
             if (!isset($shelf)) {
                $this->Flash->error(__('The Shelf is not in the database.'));
            } else {
                $tray->shelf_id = $shelf->shelf_id;
                if ($this->Trays->save($tray)) {

                    $this->Flash->success(__('The tray has been saved.'));

                    return $this->redirect(['controller' => 'books',
                                            'action' => 'scan',
                                            'tray_id' => $tray->tray_id,
                                            'count' => $this->request->getData()['num_trays'],
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
      public function scanEnd($id=null)
      {
          $tray = $this->Trays->get($id, [
              'contain' => []
          ]);
          if ($this->request->is(['patch', 'post', 'put'])) {
              $tray = $this->Trays->patchEntity($tray, $this->request->getData());
              // I don't know how to use count(*) here. So, I use toArray() and count() instead.
              $num_books = $this->Trays->Books->find('all', ['limit' => 200])
                                              ->where(['tray_id' => $id]);
              if (count($num_books->toArray()) == intval($this->request->getQuery('count'))) {
                      $tray->status_id = intval($tray->status_id)+1 ;
                      $tray->modified_user = env('REMOTE_USER', true);
                      if ($this->Trays->save($tray)) {
                          $this->Flash->success(__('The tray('.$tray->tray_barcode.') has been registered.'));
                          switch ($tray->status_id) {
                              case 3:
                                  return $this->redirect(['action' => 'index', 'filter' => 'incompleted']);
                              default:
                                  return $this->redirect(['action' => 'scanInit']);
                          }
                          return $this->redirect(['action' => 'scanInit']);
                      }
                      $this->Flash->error(__('Fail to wrap up this tray.'));
                }
              $this->Flash->error(__('The tray barcode or the amount of books is wrong.'));
          }
          $this->set(compact('tray'));
      }

      /**
       * ScanInit method
       *
       * @return \Cake\Http\Response|null Redirects to index.
       */
       public function incompleted($id=null)
       {
            $tray = $this->Trays->get($id, [
                'contain' => []
            ]);
            if ($this->request->is(['patch', 'post', 'put'])) {
                $tray = $this->Trays->patchEntity($tray, $this->request->getData());
                $tray->modified_user = env('REMOTE_USER', true);
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
                                            'count' => $this->request->getData('num_trays'),
                                            'id' => 1]);
                }
                $this->Flash->error(__('Please, try again.'));
            }
            $this->set(compact('tray'));
       }

       /**
       *
       */
        public function validate($id=null) {
            $tray = $this->Trays->get($id, [
                'contain' => []
            ]);
            $books = $this->Trays->Books->find('all', ['limit' => 200])
                                        ->where(['tray_id' => $id]);
            if ($this->request->is(['patch', 'post', 'put'])) {
                if (count($books->toArray()) != $this->request->getData('num_trays')) {
                    $this->Trays->Books->deleteAll(['tray_id' => $tray->tray_id]);
                    $tray->status_id = 1;
                    $tray->modified_user = env('REMOTE_USER', true);
                    if ($this->Trays->save($tray)) {
                        return $this->redirect(['controller' => 'books',
                                                'action' => 'scan',
                                                'tray_id' => $tray->tray_id,
                                                'count' => $this->request->getData('num_trays'),
                                                'id' => 1]);
                    }
                } else if ($tray->tray_barcode != $this->request->getData('tray_barcode')) {
                    $this->Flash->error(__("The tray barcode doesn't match."));
                } else {
                    return $this->redirect(['controller' => 'books',
                                            'action' => 'scanList',
                                            'tray_id' => $tray->tray_id,
                                            'id' => 1, //current amount
                                            'count' => $this->request->getData('num_trays')]);
                }
            }
            $amount = count($books->toArray());
            $this->set(compact('tray', 'amount'));
        }
}
