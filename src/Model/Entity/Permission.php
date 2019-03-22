<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Permission Entity
 *
 * @property int $permission_id
 * @property \Cake\I18n\FrozenTime|null $create_time
 * @property int $permission_level
 * @property string|null $permission_title
 */
class Permission extends Entity
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
        'create_time' => true,
        'permission_level' => true,
        'permission_title' => true
    ];
}
