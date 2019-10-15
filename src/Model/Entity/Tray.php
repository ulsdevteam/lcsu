<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Tray Entity
 *
 * @property int $tray_id
 * @property string|null $tray_size
 * @property string $tray_barcode
 * @property int|null $shelf_height
 * @property \Cake\I18n\FrozenTime|null $created
 * @property \Cake\I18n\FrozenTime $modified
 * @property int|null $modified_user
 *
 * @property \App\Model\Entity\Book[] $books
 */
class Tray extends Entity
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
        'tray_barcode' => true,
        'modified_user' => true,
        'shelf_id' => true,
        'tray_title' => true,
        'tray_id' => true,
        'status_id' => true,
        'validated_user' => true,
        'validated_date' => true,
    ];
}
