<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Shelf Entity
 *
 * @property int $shelf_id
 * @property string|null $shelf_barcode
 * @property int|null $shelf_height
 * @property int|null $traysize_id
 */
class Shelf extends Entity
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
        'shelf_barcode' => true,
        'shelf_height' => true,
        'traysize_id' => true,
        'module_id' => true,
        'range_title' => true,
        'tray_category' => true,
        'shelf_title' => true,
        'shelf_id' => true
    ];

    protected function _getShelfOption()
    {
        return $this->module->module_title.'-'.$this->shelf_barcode ;
    }
}
