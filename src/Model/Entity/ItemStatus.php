<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ItemStatus Entity
 *
 * @property int|null $ITEM_ID
 * @property int|null $ITEM_STATUS
 * @property \Cake\I18n\FrozenTime|null $ITEM_STATUS_DATE
 * @property string|null $ITEM_STATUS_OPERATOR
 */
class ItemStatus extends Entity
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
        'ITEM_STATUS' => true,
        'ITEM_STATUS_DATE' => true,
        'ITEM_STATUS_OPERATOR' => true
    ];
}
