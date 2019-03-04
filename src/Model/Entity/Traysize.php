<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Traysize Entity
 *
 * @property int $traysize_id
 * @property string $tray_category
 * @property int $shelf_height
 * @property int $num_trays
 */
class Traysize extends Entity
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
        'tray_category' => true,
        'shelf_height' => true,
        'num_trays' => true
    ];

    protected $_virtual = ['traysize_option'];

    protected function _getTraysizeOption()
    {
        return $this->tray_category . ' - ' . $this->shelf_height."\"";
    }
}
