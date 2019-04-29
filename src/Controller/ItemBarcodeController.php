<?php
namespace App\Controller;

use App\Controller\AppController;
use Cake\Datasource\ConnectionManager;
/**
 * ItemBarcode Controller
 *
 * @property \App\Model\Table\ItemBarcodeTable $ItemBarcode
 *
 * @method \App\Model\Entity\ItemBarcode[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ItemBarcodeController extends AppController
{
    /**
     * Index method
     *
     * @return \Cake\Http\Response|void
     */
    public function index()
    {
        $itemBarcode = $this->paginate($this->ItemBarcode);
        $connection = ConnectionManager::get('voyager'); 
//        $results=$connection->execute("SELECT * FROM ITEM_BARCODE WHERE ITEM_BARCODE = '31735013490895'")->fetchAll('assoc'); 
//        
//        echo json_encode($results);
        
        $test = $this->ItemBarcode->find('all')->where(['ITEM_BARCODE' => 31735013490895])->contain(['Item'])->first();
        $results=$connection->execute("SELECT * FROM LOCATION WHERE LOCATION_ID = ".$test['item']['PERM_LOCATION'])->fetchAll('assoc'); 
//        $location = $this->ItemBarcode->Item->find('all')->where(['LOCATION_ID' => $test['item']['PERM_LOCATION']])->contain(['Location']);
//        $location = $this->ItemBarcode->Item->where(['LOCATION_ID' => $test['item']['PERM_LOCATION']])->contain(['Location']);
        echo json_encode($test['item']['PERM_LOCATION']);
        echo json_encode($results[0]['LOCATION_CODE']);
        
        $this->set(compact('itemBarcode'));
    }

    /**
     * View method
     *
     * @param string|null $id Item Barcode id.
     * @return \Cake\Http\Response|void
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $itemBarcode = $this->ItemBarcode->get($id);

        $this->set('itemBarcode', $itemBarcode);
    }    
    
    
    public function search($item_barcode)
    {
        $connection = ConnectionManager::get('voyager');   
        $itembarcode = $this->ItemBarcode->find('all')->where(['ITEM_BARCODE' => $item_barcode, 'BARCODE_STATUS' => 1])->contain(['Item'])->first();

        $results=$connection->execute("SELECT * FROM LOCATION WHERE LOCATION_ID = ".$itembarcode['item']['PERM_LOCATION'])->fetchAll('assoc');
        if ($results[0]['LOCATION_CODE'] != 'tb') {
            $this->Flash->error("'".$item_barcode."' is not in Thomas Boulevard LCSU.");
        }
    }
    
}
