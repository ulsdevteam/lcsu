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
    public function search($item_barcode)
    {
        $itemBarcode = $this->Item->find('all', [ 'joins' => [ ['table' => 'ITEM_BARCODE', 'alias' => 'IB', 'type' => 'INNER', 'conditions' => ['IB.ITEM_BARCODE = ITEM.ITEM_BARCODE']]], 
                                                  'conditions' => ['IB.ITEM_BARCODE' => $item_barcode],
                                                  'fields' => ['IB.ITEM_BARCODE']]);
        
        echo $itemBarcode;
        return $itemBarcode;
    }
}
