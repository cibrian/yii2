<?php

use \yii\db\Migration;

class m210503_121031_add_access_token_column_to_user_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'access_token', $this->string(255)->defaultValue(NULL));
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'access_token');
    }
}
