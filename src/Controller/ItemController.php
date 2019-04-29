<?php
namespace App\Controller;

use App\Controller\AppController;

/**
 * Item Controller
 *
 * @property \App\Model\Table\ItemTable $Item
 *
 * @method \App\Model\Entity\Item[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ItemController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $item = $this->paginate($this->Item);

        $this->set(compact('item'));
    }

    /**
     * View method
     *
     * @param string|null $id Item id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $item = $this->Item->get($id, [
            'contain' => ['HOLDRECALL', 'NOTETYPE', 'ITEMSTATUS', 'ITEMTYPE', 'MEDIASCHEDULE', 'RESERVELIST']
        ]);

        $this->set('item', $item);
    }
    
    public function search($item_barcode)
    {
        $itemBarcode = $this->Item->find('all', [ 'joins' => [ ['table' => 'ITEM_BARCODE', 'alias' => 'IB', 'type' => 'INNER', 'conditions' => ['IB.ITEM_BARCODE = ITEM.ITEM_BARCODE']]], 
                                                  'conditions' => ['IB.ITEM_BARCODE' => $item_barcode],
                                                  'fields' => ['IB.ITEM_BARCODE']]);
        
        echo $itemBarcode;
        return $itemBarcode;
    }
    
    public function search2($item_barcode)
    {
        $connection = ConnectionManager::get('voyager'); 
        $results=$connection->execute("SELECT * FROM ITEMBARCODE WHERE ITEM_BARCODE = '31735013490895'")->fetchAll('assoc'); 
        
        echo json_encode($results);
        return $results;
    }
}
