<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%anunt}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m221112_190834_create_anunt_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%anunt}}', [
            'id' => $this->primaryKey()->notNull(),
            'oras' => $this->string(),
            'departament' => $this->string(),
            'data_postare' => $this->datetime(),
            'data_concurs' => $this->datetime(),
            'data_depunere_dosar' => $this->string(),
            'id_user_adaugare' => $this->integer(),
            'cale_imagine'=>$this->string()
        ]);

        // creates index for column `id_user_adaugare`
        $this->createIndex(
            '{{%idx-anunt-id_user_adaugare}}',
            '{{%anunt}}',
            'id_user_adaugare'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-anunt-id_user_adaugare}}',
            '{{%anunt}}',
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
            '{{%fk-anunt-id_user_adaugare}}',
            '{{%anunt}}'
        );

        // drops index for column `id_user_adaugare`
        $this->dropIndex(
            '{{%idx-anunt-id_user_adaugare}}',
            '{{%anunt}}'
        );

        $this->dropTable('{{%anunt}}');
    }
}
