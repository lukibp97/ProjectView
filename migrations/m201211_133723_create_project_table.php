<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%project}}`.
 */
class m201211_133723_create_project_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%project}}', [
            'id' => $this->primaryKey(),
            'filename' => $this->text(),
            'filepath' => $this->text(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%project}}');
    }
}
