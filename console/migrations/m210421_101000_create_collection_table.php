<?php

use \yii\db\Migration;

class m210421_101000_create_collection_table extends Migration
{
    public function up()
    {
        $this->createTable('collection', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'user_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-collection-user_id',
            'collection',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

    }

    public function down()
    {
        $this->dropTable('collection');
    }
}
