<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%Jobs}}`.
 */
class m221013_073700_create_Jobs_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%Jobs}}', [
            'id' => $this->primaryKey()->notNull(),
            'Denumire' => $this->string(),
            'Oras' => $this->string(),
            'Departament' => $this->string(),
            'Tip' => $this->string(),
            'Nivel_studii' => $this->string(),
            'Nivel_cariera' => $this->string(),
            'Salariu' => $this->integer(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%Jobs}}');
    }
}
