<?php

use yii\db\Migration;

/**
 * Class m210528_123819_short_url
 */
class m210528_123819_short_url extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB';

        $this->createTable('{{%short_url}}', [
            'id' => $this->primaryKey(),
            'full_url' => $this->string()->unique()->notNull(),
            'short_hash' => $this->string(8)->unique(),
            'date_create' => $this->datetime()->notNull()->defaultExpression('now()'),
            'counter' => $this->integer()->notNull()->defaultValue(0),

        ], $tableOptions);

        $this->createIndex('{{%idx-short_hash_UNIQUE}}', '{{%short_url}}', 'short_hash');

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%short_url}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210528_123819_short_url cannot be reverted.\n";

        return false;
    }
    */
}
