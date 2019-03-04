<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Book Entity
 *
 * @property int $book_id
 * @property string|null $book_title
 * @property string $book_barcode
 * @property string $tray_barcode
 *
 * @property \App\Model\Entity\Tray $tray
 */
class Book extends Entity
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
        'book_id' => true,
        'book_barcode' => true,
        'tray_id' => true
    ];
}
