<?php

use \yii\db\Migration;

class m210430_100502_add_is_admin_column_to_user_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%user}}', 'is_admin', $this->boolean()->defaultValue(false));
    }

    public function down()
    {
        $this->dropColumn('{{%user}}', 'is_admin');
    }
}
