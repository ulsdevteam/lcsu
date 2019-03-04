<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Article Entity
 *
 * @property int $article_id
 * @property string $article_name
 * @property string $article_category
 * @property string $article_content
 * @property string $article_author
 * @property \Cake\I18n\FrozenTime $timestamp
 */
class Article extends Entity
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
        'article_name' => true,
        'article_category' => true,
        'article_content' => true,
        'article_author' => true,
        'timestamp' => true
    ];
}
