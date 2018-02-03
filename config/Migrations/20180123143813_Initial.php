<?php
use Migrations\AbstractMigration;

class Initial extends AbstractMigration
{

    public $autoId = false;

    public function up()
    {

        $this->table('baryons')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('name', 'string', [
                'default' => '',
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('description', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('is_oneway', 'boolean', [
                'default' => true,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('is_private', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('gluon_types')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('name', 'string', [
                'default' => '',
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('caption', 'string', [
                'default' => '',
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('caption_ja', 'string', [
                'default' => '',
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('sort', 'integer', [
                'default' => '0',
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('ja_relations')
            ->addColumn('id', 'string', [
                'default' => '',
                'limit' => 36,
                'null' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('active_id', 'string', [
                'default' => '',
                'limit' => 36,
                'null' => false,
            ])
            ->addColumn('passive_id', 'string', [
                'default' => '',
                'limit' => 36,
                'null' => false,
            ])
            ->addColumn('relation', 'string', [
                'default' => '',
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('suffix', 'string', [
                'default' => '',
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('start', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('end', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('start_accuracy', 'string', [
                'comment' => 'year, month, day, hour, min, secのどれか',
                'default' => null,
                'limit' => 10,
                'null' => true,
            ])
            ->addColumn('end_accuracy', 'string', [
                'comment' => 'year, month, day, hour, min, secのどれか',
                'default' => null,
                'limit' => 10,
                'null' => true,
            ])
            ->addColumn('is_momentary', 'boolean', [
                'comment' => 'start, endが期間ではなく瞬間を表す場合。',
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('order_level', 'integer', [
                'comment' => '1 to 5',
                'default' => '1',
                'limit' => 3,
                'null' => false,
            ])
            ->addColumn('is_exclusive', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('last_modified_user', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('baryon_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('gluon_type_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('source', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'active_id',
                    'passive_id',
                ]
            )
            ->addIndex(
                [
                    'baryon_id',
                ]
            )
            ->create();

        $this->table('ja_subject_searches')
            ->addColumn('id', 'string', [
                'default' => '',
                'limit' => 36,
                'null' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('search_words', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'search_words',
                ],
                ['type' => 'fulltext']
            )
            ->create();

        $this->table('ja_subjects')
            ->addColumn('id', 'string', [
                'default' => '',
                'limit' => 36,
                'null' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('name', 'string', [
                'default' => '',
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('image_path', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('description', 'string', [
                'comment' => '同名単語の区別のために付ける場合がある',
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('start', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('end', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('start_accuracy', 'string', [
                'comment' => 'year, month, day, hour, min, secのどれか',
                'default' => null,
                'limit' => 10,
                'null' => true,
            ])
            ->addColumn('end_accuracy', 'string', [
                'comment' => 'year, month, day, hour, min, secのどれか',
                'default' => null,
                'limit' => 10,
                'null' => true,
            ])
            ->addColumn('is_momentary', 'boolean', [
                'comment' => 'start, endが期間ではなく瞬間を表す場合。',
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('url', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('affiliate', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('is_person', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('is_private', 'boolean', [
                'default' => true,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('is_exclusive', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('last_modified_user', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('wikipedia_sourced', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('t_dictionary_sourced', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('relative_collected', 'integer', [
                'default' => '0',
                'limit' => 3,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('wid', 'integer', [
                'default' => null,
                'limit' => 8,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('quark_type_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'name',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'wid',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'relative_collected',
                ]
            )
            ->addIndex(
                [
                    'is_person',
                ]
            )
            ->create();

        $this->table('pages')
            ->addColumn('page_id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 8,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['page_id'])
            ->addColumn('page_namespace', 'integer', [
                'default' => '0',
                'limit' => 11,
                'null' => false,
            ])
            ->addColumn('page_title', 'string', [
                'default' => '',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('page_restrictions', 'string', [
                'default' => '',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('page_counter', 'biginteger', [
                'default' => '0',
                'limit' => 20,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('page_is_redirect', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('page_is_new', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('page_random', 'float', [
                'default' => '0',
                'limit' => 0,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('page_touched', 'string', [
                'default' => '',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('page_links_updated', 'string', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('page_latest', 'integer', [
                'default' => '0',
                'limit' => 8,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('page_len', 'integer', [
                'default' => '0',
                'limit' => 8,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('page_content_model', 'string', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('page_lang', 'string', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('is_treated', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addIndex(
                [
                    'page_namespace',
                    'page_title',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'page_random',
                ]
            )
            ->addIndex(
                [
                    'page_len',
                ]
            )
            ->addIndex(
                [
                    'page_is_redirect',
                    'page_namespace',
                    'page_len',
                ]
            )
            ->create();

        $this->table('qproperty_gtypes')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('quark_property_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('gluon_type_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('sides', 'integer', [
                'comment' => '0: both, 1: A -> B, 2: B -> A',
                'default' => '0',
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('qproperty_types')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('quark_property_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('quark_type_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('qtype_properties')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('quark_type_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('quark_property_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('is_required', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('quark_properties')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('name', 'string', [
                'default' => '',
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('caption', 'string', [
                'default' => '',
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('caption_ja', 'string', [
                'default' => '',
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('quark_types')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('name', 'string', [
                'default' => '',
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('image_path', 'string', [
                'default' => '',
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('name_prop', 'string', [
                'default' => '',
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('start_prop', 'string', [
                'default' => '',
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('end_prop', 'string', [
                'default' => '',
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('has_gender', 'integer', [
                'default' => '0',
                'limit' => 3,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('sort', 'integer', [
                'default' => '0',
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->create();

        $this->table('relations')
            ->addColumn('id', 'string', [
                'default' => '',
                'limit' => 36,
                'null' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('active_id', 'string', [
                'default' => '',
                'limit' => 36,
                'null' => false,
            ])
            ->addColumn('passive_id', 'string', [
                'default' => '',
                'limit' => 36,
                'null' => false,
            ])
            ->addColumn('relation', 'string', [
                'default' => '',
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('suffix', 'string', [
                'default' => '',
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('start', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('end', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('start_accuracy', 'string', [
                'comment' => 'year, month, day, hour, min, secのどれか',
                'default' => null,
                'limit' => 10,
                'null' => true,
            ])
            ->addColumn('end_accuracy', 'string', [
                'comment' => 'year, month, day, hour, min, secのどれか',
                'default' => null,
                'limit' => 10,
                'null' => true,
            ])
            ->addColumn('is_momentary', 'boolean', [
                'comment' => 'start, endが期間ではなく瞬間を表す場合。',
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('order_level', 'integer', [
                'comment' => '1 to 5',
                'default' => '1',
                'limit' => 3,
                'null' => false,
            ])
            ->addColumn('is_exclusive', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('last_modified_user', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('baryon_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('gluon_type_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('source', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'active_id',
                    'passive_id',
                ]
            )
            ->addIndex(
                [
                    'baryon_id',
                ]
            )
            ->create();

        $this->table('subject_searches')
            ->addColumn('id', 'string', [
                'default' => '',
                'limit' => 36,
                'null' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('search_words', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'search_words',
                ],
                ['type' => 'fulltext']
            )
            ->create();

        $this->table('subjects')
            ->addColumn('id', 'string', [
                'default' => '',
                'limit' => 36,
                'null' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('name', 'string', [
                'default' => '',
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('image_path', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('description', 'string', [
                'comment' => '同名単語の区別のために付ける場合がある',
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('start', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('end', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('start_accuracy', 'string', [
                'comment' => 'year, month, day, hour, min, secのどれか',
                'default' => null,
                'limit' => 10,
                'null' => true,
            ])
            ->addColumn('end_accuracy', 'string', [
                'comment' => 'year, month, day, hour, min, secのどれか',
                'default' => null,
                'limit' => 10,
                'null' => true,
            ])
            ->addColumn('is_momentary', 'boolean', [
                'comment' => 'start, endが期間ではなく瞬間を表す場合。',
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('url', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('affiliate', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('is_person', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('is_private', 'boolean', [
                'default' => true,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('is_exclusive', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('last_modified_user', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('wikipedia_sourced', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('t_dictionary_sourced', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('relative_collected', 'integer', [
                'default' => '0',
                'limit' => 3,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('wid', 'integer', [
                'default' => null,
                'limit' => 8,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('quark_type_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => true,
                'signed' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'name',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'wid',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'relative_collected',
                ]
            )
            ->addIndex(
                [
                    'is_person',
                ]
            )
            ->create();

        $this->table('users')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('username', 'string', [
                'default' => '',
                'limit' => 50,
                'null' => false,
            ])
            ->addColumn('password', 'string', [
                'default' => '',
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('role', 'string', [
                'default' => 'author',
                'limit' => 20,
                'null' => false,
            ])
            ->addColumn('default_saving_privacy', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('default_showing_privacy', 'integer', [
                'default' => '3',
                'limit' => 3,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'username',
                ],
                ['unique' => true]
            )
            ->create();
    }

    public function down()
    {
        $this->dropTable('baryons');
        $this->dropTable('gluon_types');
        $this->dropTable('ja_relations');
        $this->dropTable('ja_subject_searches');
        $this->dropTable('ja_subjects');
        $this->dropTable('pages');
        $this->dropTable('qproperty_gtypes');
        $this->dropTable('qproperty_types');
        $this->dropTable('qtype_properties');
        $this->dropTable('quark_properties');
        $this->dropTable('quark_types');
        $this->dropTable('relations');
        $this->dropTable('subject_searches');
        $this->dropTable('subjects');
        $this->dropTable('users');
    }
}
