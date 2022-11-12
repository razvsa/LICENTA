<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%Jobs}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m221112_190738_create_Jobs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%Jobs}}', [
            'id' => $this->primaryKey()->notNull(),
            'oras' => $this->string(),
            'departament' => $this->string(),
            'data_postare' => $this->datetime(),
            'data_concurs' => $this->datetime(),
            'data_depunere_dosar' => $this->string(),
            'id_user_adaugare' => $this->integer(),
        ]);

        // creates index for column `id_user_adaugare`
        $this->createIndex(
            '{{%idx-Jobs-id_user_adaugare}}',
            '{{%Jobs}}',
            'id_user_adaugare'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-Jobs-id_user_adaugare}}',
            '{{%Jobs}}',
            'id_user_adaugare',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-Jobs-id_user_adaugare}}',
            '{{%Jobs}}'
        );

        // drops index for column `id_user_adaugare`
        $this->dropIndex(
            '{{%idx-Jobs-id_user_adaugare}}',
            '{{%Jobs}}'
        );

        $this->dropTable('{{%Jobs}}');
    }
}
