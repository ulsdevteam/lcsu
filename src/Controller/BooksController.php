<?php
namespace App\Controller;

use App\Controller\AppController;

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
     * Add method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $book = $this->Books->newEntity();
        if ($this->request->is('post')) {
            $book = $this->Books->patchEntity($book, $this->request->getData());
            $tray_id = $this->request->getQuery('tray_id');
            $book->tray_id = $tray_id;
            if ($this->Books->save($book)) {
                $this->Flash->success(__('The book has been saved.'));

                return $this->redirect(['controller' => 'Trays', 'action' => 'view/'.$tray_id]);
            }
            $this->Flash->error(__('The book could not be saved. Please, try again.'));
        }
        $trays = $this->Books->Trays->find('list', ['limit' => 200]);
        $this->set(compact('book', 'trays'));
    }

    /**
     * Edit method
     *
     * @param string|null $id Book id.
     * @return \Cake\Http\Response|null Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $book = $this->Books->get($id, [
            'contain' => []
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $book = $this->Books->patchEntity($book, $this->request->getData());
            if ($this->Books->save($book)) {
                $this->Flash->success(__('The book has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The book could not be saved. Please, try again.'));
        }
        $trays = $this->Books->Trays->find('list', ['limit' => 200]);
        $this->set(compact('book', 'trays'));
    }

    /**
     * Delete method
     *
     * @param string|null $id Book id.
     * @return \Cake\Http\Response|null Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $book = $this->Books->get($id);
        if ($this->Books->delete($book)) {
            $this->Flash->success(__('The book has been deleted.'));
        } else {
            $this->Flash->error(__('The book could not be deleted. Please, try again.'));
        }

        return $this->redirect($this->referer());
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
            $book = $this->Books->patchEntity($book, $this->request->getData());
            $book->tray_id = $this->request->getQuery('tray_id');
            if ($this->Books->save($book)) {
                $this->Flash->success(__('The book has been saved.'));

                $id =  $this->request->getQuery('id');
                $count = $this->request->getQuery('count');
                if ( $id + 1 > $count) {
                    // Wrap up the process
                    return $this->redirect(['controller' => 'trays',
                                            'action' => 'scanEnd/'.$book['tray_id'],
                                            'count' => $count]);
                } else {
                    // Keep to scanning the next book
                    return $this->redirect(['action' => 'scan',
                                            'tray_id' => $book['tray_id'],
                                            'count' => $count,
                                            'id' => $id+1]);
                }
            }
            $this->Flash->error(__('The book could not be saved. Please, try again.'));
        }
        $trays = $this->Books->Trays->find('list', ['limit' => 200]);
        $this->set(compact('book', 'trays'));
    }

    /**
     * Scan method
     *
     * @return \Cake\Http\Response|null Redirects on successful add, renders view otherwise.
     */
    public function scanList()
    {
        $book = $this->Books->newEntity();
        if ($this->request->is('post')) {
            $book = $this->Books->patchEntity($book, $this->request->getData());
            $book->tray_id = $this->request->getQuery('tray_id');
            if ($this->Books->save($book)) {
                $this->Flash->success(__('The book has been saved.'));

                $id =  $this->request->getQuery('id');
                $count = $this->request->getQuery('count');
                if ( $id + 1 > $count) {
                    // Wrap up the process
                    return $this->redirect(['controller' => 'trays',
                                            'action' => 'scanEnd',
                                            'tray_id' => $book['tray_id'],
                                            'count' => $count]);
                } else {
                    // Keep to scanning the next book
                    return $this->redirect(['action' => 'scan',
                                            'tray_id' => $book['tray_id'],
                                            'count' => $count,
                                            'id' => $id+1]);
                }
            }
            $this->Flash->error(__('The book could not be saved. Please, try again.'));
        }
        $bookList = $this->Books->find('all', ['limit' => 200])
                                        ->where(['tray_id' => $this->request->getQuery('tray_id')]);
        $this->set(compact('book', 'bookList'));
    }

    /**
     * get book list method
     *
     */
    public function bookList()
    {
        $this->viewBuilder()->layout(false);
        $bookList = $this->Books->find('all', ['limit' => 20])
                                ->where(['tray_id' => $this->request->getQuery('tray_id')]);
        $this->set('bookList', json_encode($bookList));
    }

    public function deleteBooksByTray($tray_id) {
        if ($tray_id && $source) {
            $books = $this->Books->find('all', ['limit' => 200])
                                        ->where(['tray_id' => $tray_id]);
            if (count($books->toArray()) > 0) {
                $this->Books->deleteAll(['tray_id' => $tray_id]);
            }
        }
    }
}
