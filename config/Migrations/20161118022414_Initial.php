<?php
use Migrations\AbstractMigration;

class Initial extends AbstractMigration
{
    public function up()
    {

        $this->table('relations', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'string', [
                'default' => '',
                'limit' => 36,
                'null' => false,
            ])
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
                ],
                ['unique' => true]
            )
            ->create();

        $this->table('subject_searches', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'string', [
                'default' => '',
                'limit' => 36,
                'null' => false,
            ])
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

        $this->table('subjects', ['id' => false, 'primary_key' => ['id']])
            ->addColumn('id', 'string', [
                'default' => '',
                'limit' => 36,
                'null' => false,
            ])
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
                ]
            )
            ->create();
    }

    public function down()
    {
        $this->dropTable('relations');
        $this->dropTable('subject_searches');
        $this->dropTable('subjects');
    }
}
