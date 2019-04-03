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
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function scan()
    {
        $book = $this->Books->newEntity();
        if ($this->request->is('post')) {
            $tray = $this->Books->Trays->get($this->request->getQuery('tray_id'));
            
            if ($tray->status_id == Configure::read('Incompleted')) {
                $book = $this->Books->patchEntity($book, $this->request->getData());
                $book->tray_id = $tray->tray_id;
                if ($this->Books->save($book)) {
                    $this->Flash->success(__('The book has been saved.'));

                    $id =  $this->request->getQuery('id');
                    $count = $this->request->getQuery('count');
                    if ($id + 1 > $count) {
                        // Wrap up the process
                        return $this->redirect(['controller' => 'trays',
                                                'action' => 'scanEnd',
                                                $book['tray_id'],
                                                'source' => $this->request->getQuery('source'),
                                                'count' => $count]);
                    } else {
                        // Keep to scanning the next book
                        return $this->redirect(['action' => 'scan',
                                                'tray_id' => $book['tray_id'],
                                                'source' => $this->request->getQuery('source'),
                                                'count' => $count,
                                                'id' => $id+1]);
                    }
                }
            }
            $this->Flash->error(__('The book could not be saved. Please, try again.'));
        }
        $this->set(compact('book'));
    }
}
