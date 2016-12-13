<?php
use yii\db\Migration;

class m161210_131014_multilang_init extends Migration
{
    public function up()
    {
        $tableOptions = NULL;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }


        // -------------------------------------------
        // Create lang table
        // -------------------------------------------

        // Lang table
        $this->createTable('{{%lang}}', [
            'id' => $this->primaryKey(),
            'url' => $this->string(2)->notNull()->unique(),
            'locale' => $this->string(16)->notNull()->unique(),
            'name' => $this->string()->notNull(),
            'default' => $this->smallInteger(1)->notNull()->defaultValue(0),

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        // Add default languages
        $this->insert('{{%lang}}', [
            'url' => 'ru',
            'locale' => 'ru-RU',
            'name' => 'Русский',
            'default' => 1,
            'created_at' => time(),
            'updated_at' => time(),
        ]);
        $this->insert('{{%lang}}', [
            'url' => 'uk',
            'locale' => 'uk-UA',
            'name' => 'Українська',
            'created_at' => time(),
            'updated_at' => time(),
        ]);
        $this->insert('{{%lang}}', [
            'url' => 'en',
            'locale' => 'en-US',
            'name' => 'English',
            'created_at' => time(),
            'updated_at' => time(),
        ]);

        // Add translate tables
        $this->createTable('{{%source_message}}', [
            'id' => $this->primaryKey(),
            'category' => $this->string(32),
            'message' => $this->text()->notNull(),

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
        $this->createTable('{{%message}}', [
            'id' => $this->integer(),
            'language' => $this->string(16),
            'translation' => $this->text(),

            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->createIndex('message_id_language', '{{%message}}', ['id', 'language'], true);
        $this->addForeignKey('fk_message_source_message', '{{%message}}', 'id', '{{%source_message}}', 'id', 'CASCADE', 'RESTRICT');
    }

    public function down()
    {
        $this->dropTable('{{%message}}');
        $this->dropTable('{{%source_message}}');
        $this->dropTable('{{%lang}}');
    }
}
