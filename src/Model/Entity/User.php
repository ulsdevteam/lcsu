<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * User Entity
 *
 * @property int $user_id
 * @property string $username
 * @property int $permission_id
 * @property \Cake\I18n\FrozenTime|null $create_time
 *
 * @property \App\Model\Entity\Permission $permission
 */
class User extends Entity
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
        'username' => true,
        'permission_id' => true,
        'create_time' => true,
        'permission' => true
    ];
}
