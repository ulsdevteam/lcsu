<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ItemBarcode Entity
 *
 * @property int|null $ITEM_ID
 * @property string|null $ITEM_BARCODE
 * @property int|null $BARCODE_STATUS
 * @property \Cake\I18n\FrozenTime|null $BARCODE_STATUS_DATE
 */
class ItemBarcode extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'ITEM_ID' => true,
        'ITEM_BARCODE' => true,
        'BARCODE_STATUS' => true,
        'BARCODE_STATUS_DATE' => true
    ];
}
