<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Item Entity
 *
 * @property int|null $ITEM_ID
 * @property int|null $PERM_LOCATION
 * @property int|null $TEMP_LOCATION
 * @property int|null $ITEM_TYPE_ID
 * @property int|null $TEMP_ITEM_TYPE_ID
 * @property int|null $COPY_NUMBER
 * @property string|null $ON_RESERVE
 * @property int|null $RESERVE_CHARGES
 * @property int|null $PIECES
 * @property int|null $PRICE
 * @property string|null $SPINE_LABEL
 * @property int|null $HISTORICAL_CHARGES
 * @property int|null $HISTORICAL_BROWSES
 * @property int|null $RECALLS_PLACED
 * @property int|null $HOLDS_PLACED
 * @property \Cake\I18n\FrozenTime|null $CREATE_DATE
 * @property \Cake\I18n\FrozenTime|null $MODIFY_DATE
 * @property string|null $CREATE_OPERATOR_ID
 * @property string|null $MODIFY_OPERATOR_ID
 * @property int|null $CREATE_LOCATION_ID
 * @property int|null $MODIFY_LOCATION_ID
 * @property int|null $ITEM_SEQUENCE_NUMBER
 * @property int|null $HISTORICAL_BOOKINGS
 * @property int|null $MEDIA_TYPE_ID
 * @property int|null $SHORT_LOAN_CHARGES
 * @property string|null $MAGNETIC_MEDIA
 * @property string|null $SENSITIZE
 *
 * @property \App\Model\Entity\HOLDRECALL[] $h_o_l_d_r_e_c_a_l_l
 * @property \App\Model\Entity\NOTETYPE[] $n_o_t_e_t_y_p_e
 * @property \App\Model\Entity\ITEMSTATU[] $i_t_e_m_s_t_a_t_u_s
 * @property \App\Model\Entity\ITEMTYPE[] $i_t_e_m_t_y_p_e
 * @property \App\Model\Entity\MEDIASCHEDULE[] $m_e_d_i_a_s_c_h_e_d_u_l_e
 * @property \App\Model\Entity\RESERVELIST[] $r_e_s_e_r_v_e_l_i_s_t
 */
class Item extends Entity
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
        'PERM_LOCATION' => true,
        'TEMP_LOCATION' => true,
        'ITEM_TYPE_ID' => true,
        'TEMP_ITEM_TYPE_ID' => true,
        'COPY_NUMBER' => true,
        'ON_RESERVE' => true,
        'RESERVE_CHARGES' => true,
        'PIECES' => true,
        'PRICE' => true,
        'SPINE_LABEL' => true,
        'HISTORICAL_CHARGES' => true,
        'HISTORICAL_BROWSES' => true,
        'RECALLS_PLACED' => true,
        'HOLDS_PLACED' => true,
        'CREATE_DATE' => true,
        'MODIFY_DATE' => true,
        'CREATE_OPERATOR_ID' => true,
        'MODIFY_OPERATOR_ID' => true,
        'CREATE_LOCATION_ID' => true,
        'MODIFY_LOCATION_ID' => true,
        'ITEM_SEQUENCE_NUMBER' => true,
        'HISTORICAL_BOOKINGS' => true,
        'MEDIA_TYPE_ID' => true,
        'SHORT_LOAN_CHARGES' => true,
        'MAGNETIC_MEDIA' => true,
        'SENSITIZE' => true,
        'h_o_l_d_r_e_c_a_l_l' => true,
        'n_o_t_e_t_y_p_e' => true,
        'i_t_e_m_s_t_a_t_u_s' => true,
        'i_t_e_m_t_y_p_e' => true,
        'm_e_d_i_a_s_c_h_e_d_u_l_e' => true,
        'r_e_s_e_r_v_e_l_i_s_t' => true
    ];
}
