<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * SubjectsFixture
 *
 */
class SubjectsFixture extends TestFixture
{
    public $import = ['table' => 'subjects'];

    /**
     * Records
     *
     * @var array
     */
    public $records = [
        [
            'id'                 => '1',
            'name'               => '上白石萌歌',
            'image_path'         => '',
            'description'        => '',
            'start'              => NULL,
            'end'                => NULL,
            'start_accuracy'     => '',
            'end_accuracy'       => '',
            'is_momentary'       => false,
	    'url'                => 'http://hoge.com',
	    'affiliate'          => 'http://hoge.com',
	    'is_private'         => false,
	    'is_exclusive'       => false,
	    'user_id'            => 2,
	    'last_modified_user' => 2,
            'created'            => '2016-11-01 06:32:38',
            'modified'           => '2016-11-01 06:32:38'
        ],
        [
            'id'                 => '2',
            'name'               => '白間 美瑠', // Space in between
            'image_path'         => 'http://hoge.com/original_image.jpg',
            'description'        => 'Original description',
            'start'              => '1997-10-14 00:00:00',
            'end'                => NULL,
            'start_accuracy'     => '',
            'end_accuracy'       => '',
            'is_momentary'       => false,
	    'url'                => 'http://hoge.com',
	    'affiliate'          => 'http://hoge.com',
	    'is_private'         => false,
	    'is_exclusive'       => false,
	    'user_id'            => 2,
	    'last_modified_user' => 2,
            'created'            => '2016-11-01 06:32:38',
            'modified'           => '2016-11-01 06:32:38'
        ],
        [
            'id'                 => '3',
            'name'               => '芦田愛菜', // Space
            'image_path'         => '',
            'description'        => '',
            'start'              => NULL,
            'end'                => NULL,
            'start_accuracy'     => '',
            'end_accuracy'       => '',
            'is_momentary'       => false,
	    'url'                => 'http://hoge.com',
	    'affiliate'          => 'http://hoge.com',
	    'is_private'         => false,
	    'is_exclusive'       => false,
	    'user_id'            => 2,
	    'last_modified_user' => 2,
            'created'            => '2016-11-01 06:32:38',
            'modified'           => '2016-11-01 06:32:38'
        ],
        [
            'id'                 => '4',
            'name'               => '芦田愛菜',
            'image_path'         => '',
            'description'        => '',
            'start'              => NULL,
            'end'                => NULL,
            'start_accuracy'     => '',
            'end_accuracy'       => '',
            'is_momentary'       => false,
	    'url'                => 'http://hoge.com',
	    'affiliate'          => 'http://hoge.com',
	    'is_private'         => false,
	    'is_exclusive'       => false,
	    'user_id'            => 2,
	    'last_modified_user' => 2,
            'created'            => '2016-11-01 06:32:38',
            'modified'           => '2016-11-01 06:32:38'
        ],
        [
            'id'                 => '5',
            'name'               => '朝長美桜',
            'image_path'         => 'http://original.com/hoge.jpg',
            'description'        => 'original description',
            'start'              => '1998-01-01 00:00:00', // year based
            'end'                => NULL,
            'start_accuracy'     => 'year',                // year based
            'end_accuracy'       => '',
            'is_momentary'       => false,
	    'url'                => 'http://hoge.com',
	    'affiliate'          => 'http://hoge.com',
	    'is_private'         => false,
	    'is_exclusive'       => false,
	    'user_id'            => 2,
	    'last_modified_user' => 2,
            'created'            => '2016-11-01 06:32:38',
            'modified'           => '2016-11-01 06:32:38'
        ],
        [
            'id'                 => '6',
            'name'               => '向井地美音',
            'image_path'         => '',
            'description'        => '',
            'start'              => '1998-01-29 00:00:00', // accurate
            'end'                => NULL,
            'start_accuracy'     => '',                    // accurate
            'end_accuracy'       => '',
            'is_momentary'       => false,
	    'url'                => 'http://hoge.com',
	    'affiliate'          => 'http://hoge.com',
	    'is_private'         => false,
	    'is_exclusive'       => false,
	    'user_id'            => 2,
	    'last_modified_user' => 2,
            'created'            => '2016-11-01 06:32:38',
            'modified'           => '2016-11-01 06:32:38'
        ],
        [
            'id'                 => '7',
            'name'               => '石田純一',
            'image_path'         => '',
            'description'        => '',
            'start'              => NULL, // accurate
            'end'                => NULL,
            'start_accuracy'     => '',                    // accurate
            'end_accuracy'       => '',
            'is_momentary'       => false,
	    'url'                => '',
	    'affiliate'          => 'http://hoge.com',
	    'is_private'         => false,
	    'is_exclusive'       => false,
	    'user_id'            => 2,
	    'last_modified_user' => 2,
            'created'            => '2016-11-01 06:32:38',
            'modified'           => '2016-11-01 06:32:38'
        ],
    ];
}
