<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * PagesFixture
 *
 */
class PagesFixture extends TestFixture
{
    public $import = ['table' => 'pages'];

    // @codingStandardsIgnoreEnd

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'page_id' => 1,
            'page_namespace' => 1,
            'page_title' => 'title',
            'page_restrictions' => 'restriction',
            'page_counter' => 1,
            'page_is_redirect' => 1,
            'page_is_new' => 1,
            'page_random' => 1,
            'page_touched' => '20171127095114',
            'page_links_updated' => '20171127095059',
            'page_latest' => 1,
            'page_len' => 1,
            'page_content_model' => 'wikitext',
            'page_lang' => NULL,
	    'is_treated' => false
        ],
    ];
}
