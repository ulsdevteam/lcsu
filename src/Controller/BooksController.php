<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Core\Configure;
/**
 * Books Controller
 *
 * @property \App\Model\Table\BooksTable $Books
 *
 * @method \App\Model\Entity\Book[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class BooksController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $this->paginate = [
            'contain' => ['Trays']
        ];
        $books = $this->paginate($this->Books);

        $this->set(compact('books'));
    }

    /**
     * View method
     *
     * @param string|null $id Book id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $book = $this->Books->get($id, [
            'contain' => ['Trays']
        ]);

        $this->set('book', $book);
    }

    /**
     * Scan method
     *
     * @var $tray
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function scan($tray_id)
    {
        $bookIngest = $this->Books->newEntity();
        $block_item = null;
        $tray = $this->Books->Trays->get($tray_id);
        $count = $this->request->getQuery('count');
        $progress = $this->Books->find('all')->where(['tray_id' => $tray_id])->count();
        
        if ($this->request->is('post')) {
            if ($tray->status_id == Configure::read('Incompleted')) {
                $bookIngest = $this->Books->patchEntity($bookIngest, $this->request->getData());
                if ($bookIngest->getErrors()) {
                    foreach ($bookIngest->getErrors()as $error) {
                        foreach ($error as $key => $msg) {
                            if ($key === 'unique') {
                                $this->Flash->error(__('This book has already been added.'));
                            } else {
                                $this->Flash->error($msg);
                            }
                        }
                    }
                } else {
                    $itembarcode = $this->loadModel('ItemBarcode');
                    $isExist = $itembarcode->find('all')->where(['ITEM_BARCODE' => $bookIngest->book_barcode, 'BARCODE_STATUS' => 1])->count();
                    if ($isExist) {
                        if ($this->Books->save($bookIngest)) {
                            $this->Flash->success(__('The book has been saved.'));

                            $progress = $this->Books->find('all')->where(['tray_id' => $tray_id])->count();
                            if ($progress == $count) {
                                // Wrap up the process
                                return $this->redirect(['controller' => 'trays',
                                                        'action' => 'scanEnd',
                                                        $bookIngest['tray_id'],
                                                        'count' => $count]);
                            }
                        } else {
                            $this->Flash->error(__('The book could not be saved. Please, try again.'));
                        }
                    } else {
                        $this->Flash->error(__('This barcode was not found in Voyager!'));
                        $block_item = $bookIngest->book_barcode;
                    }
                }
            }
        }
        $book = $this->Books->newEntity();
        $progress = $progress + 1;
        $this->set(compact('book', 'block_item', 'tray_id', 'progress'));
    }
}
