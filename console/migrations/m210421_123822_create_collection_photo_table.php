<?php

use \yii\db\Migration;

class m210421_123822_create_collection_photo_table extends Migration
{
    public function up()
    {
        $this->createTable('collection_photo', [
            'collection_id' => $this->integer()->notNull(),
            'photo_id' => $this->string()->notNull(),
            'photo_path' => $this->string()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-collection-photo-collection_id',
            'collection_photo',
            'collection_id',
            'collection',
            'id',
            'CASCADE'
        );

    }

    public function down()
    {
        $this->dropTable('collection_photo');
    }
}
