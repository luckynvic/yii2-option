<?php

use yii\db\Migration;

/**
 * Handles the creation for table `option`.
 */
class m160818_000522_create_option_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('option', [
            'id' => $this->primaryKey(),
            'id' => $this->string(),
            'content' => $this->text(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('option');
    }
}
