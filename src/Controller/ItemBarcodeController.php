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
     * Search method, to check the item existence in voyager
     *
     * @param string $item_barcode book_barcode.
     * @return boolean return false indicates that the item is invalid.
     */
    public function search($item_barcode)
    {
        $result = $this->ItemBarcode->find('all')->where(['ITEM_BARCODE' => $item_barcode, 'BARCODE_STATUS' => 1])->first();
        return isset($result);
    }
}
