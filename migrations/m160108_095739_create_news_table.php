<?php

use yii\db\Schema;
use yii\db\Migration;

class m160108_095739_create_news_table extends Migration
{
    public function up()
    {
		$sql = file_get_contents(dirname(__FILE__) . DIRECTORY_SEPARATOR . 'sql' . DIRECTORY_SEPARATOR . $this->className() . '.sql');
        $this->execute($sql);
    }

    public function down()
    {
        echo "m160108_095739_create_news_table cannot be reverted.\n";

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
