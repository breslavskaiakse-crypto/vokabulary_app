<?php

use Phinx\Migration\AbstractMigration;

class InitialSchema extends AbstractMigration
{
    public function change()
    {
        // Users table
        if (!$this->hasTable('Users')) {
            $users = $this->table('Users', ['id' => false, 'primary_key' => ['id']]);
            $users->addColumn('id', 'integer', ['identity' => true, 'signed' => false])
                  ->addColumn('Name', 'string', ['limit' => 255, 'null' => false])
                  ->addColumn('Email', 'string', ['limit' => 255, 'null' => false])
                  ->addColumn('Password', 'string', ['limit' => 255, 'null' => true])
                  ->addIndex(['Email'], ['unique' => true, 'name' => 'idx_email'])
                  ->create();
        }

        // Sets table
        if (!$this->hasTable('Sets')) {
            $sets = $this->table('Sets', ['id' => false, 'primary_key' => ['id']]);
            $sets->addColumn('id', 'integer', ['identity' => true, 'signed' => false])
                 ->addColumn('set_id', 'integer', ['signed' => false, 'null' => false])
                 ->addColumn('user_id', 'integer', ['signed' => false, 'null' => false])
                 ->addColumn('name', 'string', ['limit' => 255, 'null' => false])
                 ->addColumn('word', 'string', ['limit' => 255, 'null' => false])
                 ->addColumn('translation', 'string', ['limit' => 255, 'null' => false])
                 ->addIndex(['set_id'], ['name' => 'idx_set_id'])
                 ->addIndex(['user_id'], ['name' => 'idx_user_id'])
                 ->addIndex(['name'], ['name' => 'idx_name'])
                 ->create();
        }

        // LibrarySets table
        if (!$this->hasTable('LibrarySets')) {
            $librarySets = $this->table('LibrarySets', ['id' => false, 'primary_key' => ['id']]);
            $librarySets->addColumn('id', 'integer', ['identity' => true, 'signed' => false])
                        ->addColumn('name', 'string', ['limit' => 255, 'null' => false])
                        ->addColumn('topic', 'string', ['limit' => 100, 'null' => false])
                        ->addColumn('source_language', 'string', ['limit' => 50, 'null' => false])
                        ->addColumn('target_language', 'string', ['limit' => 50, 'null' => false])
                        ->addColumn('level', 'string', ['limit' => 50, 'null' => true])
                        ->addColumn('description', 'text', ['null' => true])
                        ->addColumn('word_count', 'integer', ['default' => 0])
                        ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
                        ->addIndex(['topic'], ['name' => 'idx_topic'])
                        ->addIndex(['source_language'], ['name' => 'idx_source_language'])
                        ->addIndex(['target_language'], ['name' => 'idx_target_language'])
                        ->addIndex(['level'], ['name' => 'idx_level'])
                        ->create();
        }

        // LibrarySetWords table
        if (!$this->hasTable('LibrarySetWords')) {
            $librarySetWords = $this->table('LibrarySetWords', ['id' => false, 'primary_key' => ['id']]);
            $librarySetWords->addColumn('id', 'integer', ['identity' => true, 'signed' => false])
                             ->addColumn('library_set_id', 'integer', ['signed' => false, 'null' => false])
                             ->addColumn('word', 'string', ['limit' => 255, 'null' => false])
                             ->addColumn('translation', 'string', ['limit' => 255, 'null' => false])
                             ->addIndex(['library_set_id'], ['name' => 'idx_library_set_id'])
                             ->addForeignKey('library_set_id', 'LibrarySets', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
                             ->create();
        }

        // LibrarySetDefinitions table
        if (!$this->hasTable('LibrarySetDefinitions')) {
            $librarySetDefinitions = $this->table('LibrarySetDefinitions', ['id' => false, 'primary_key' => ['id']]);
            $librarySetDefinitions->addColumn('id', 'integer', ['identity' => true, 'signed' => false])
                                   ->addColumn('name', 'string', ['limit' => 255, 'null' => false])
                                   ->addColumn('topic', 'string', ['limit' => 100, 'null' => false])
                                   ->addColumn('source_language', 'string', ['limit' => 50, 'null' => false])
                                   ->addColumn('target_language', 'string', ['limit' => 50, 'null' => false])
                                   ->addColumn('level', 'string', ['limit' => 50, 'null' => true])
                                   ->addColumn('description', 'text', ['null' => true])
                                   ->addColumn('words_json', 'text', ['null' => false])
                                   ->addColumn('status', 'enum', ['values' => ['pending', 'processing', 'completed', 'failed'], 'default' => 'pending'])
                                   ->addColumn('created_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'null' => false])
                                   ->addColumn('updated_at', 'timestamp', ['default' => 'CURRENT_TIMESTAMP', 'update' => 'CURRENT_TIMESTAMP', 'null' => false])
                                   ->addIndex(['status'], ['name' => 'idx_status'])
                                   ->addIndex(['topic'], ['name' => 'idx_topic'])
                                   ->addIndex(['source_language'], ['name' => 'idx_source_language'])
                                   ->addIndex(['target_language'], ['name' => 'idx_target_language'])
                                   ->create();
        }
    }
}


