<?php

use yii\db\Migration;

class m160316_141703_extend_role_user extends Migration
{
    public function up()
    {
        $this->addColumn('easyii_admins', 'role', 'CHAR(10) NULL DEFAULT NULL');
    }

    public function down()
    {
        echo "m160316_141703_extend_role_user cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
