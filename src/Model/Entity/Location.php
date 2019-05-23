<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Location Entity
 *
 * @property int|null $LOCATION_ID
 * @property string|null $LOCATION_CODE
 * @property string|null $LOCATION_NAME
 * @property string|null $LOCATION_DISPLAY_NAME
 * @property string|null $LOCATION_SPINE_LABEL
 * @property string|null $LOCATION_OPAC
 * @property string|null $SUPPRESS_IN_OPAC
 * @property int|null $LIBRARY_ID
 * @property int|null $MFHD_COUNT
 *
 * @property \App\Model\Entity\LEDGER[] $LEDGER
 * @property \App\Model\Entity\REQUESTGROUP[] $REQUESTGROUP
 * @property \App\Model\Entity\SORTGROUP[] $SORTGROUP
 */
class Location extends Entity
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
        'LOCATION_ID' => true,
        'LOCATION_CODE' => true,
        'LOCATION_NAME' => true,
        'LOCATION_DISPLAY_NAME' => true,
        'LOCATION_SPINE_LABEL' => true,
        'LOCATION_OPAC' => true,
        'SUPPRESS_IN_OPAC' => true,
        'LIBRARY_ID' => true,
        'MFHD_COUNT' => true,
        'LEDGER' => true,
        'REQUESTGROUP' => true,
        'SORTGROUP' => true
    ];
}
