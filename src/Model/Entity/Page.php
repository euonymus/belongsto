<?php
namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Page Entity
 *
 * @property int $page_id
 * @property int $page_namespace
 * @property string $page_title
 * @property string $page_restrictions
 * @property int $page_counter
 * @property bool $page_is_redirect
 * @property bool $page_is_new
 * @property float $page_random
 * @property string $page_touched
 * @property string $page_links_updated
 * @property int $page_latest
 * @property int $page_len
 * @property string $page_content_model
 * @property string $page_lang
 * @property bool $is_treated
 *
 * @property \App\Model\Entity\Page $page
 */
class Page extends Entity
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
        '*' => true,
        'page_id' => false
    ];
}
