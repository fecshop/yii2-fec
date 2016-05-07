<?php

use yii\db\Schema;
use yii\db\Migration;

class m160108_101859_create_andinsert extends Migration
{
    public function up()
    {
		$sql = "CREATE TABLE IF NOT EXISTS `dp_admin_group11` (
  `group_id` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增ID',
  `name` varchar(255) NOT NULL COMMENT '名称',
  `is_system` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '系统用户组 0.否,1.是',
  `note` varchar(255) NOT NULL COMMENT '备注',
  `status` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '状态 0.禁止,1.启用,2.删除',
  PRIMARY KEY (`group_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='管理员用户组' AUTO_INCREMENT=6 ;

INSERT INTO `dp_admin_group11` (`group_id`, `name`, `is_system`, `note`, `status`) VALUES
(1, '系统管理员', 1, '可以管理系统的大多功能，包括后台的菜单设置，一般开发人员使用。', 1),
(2, '管理员', 1, '一般用于开权限帐号使用', 1),
(3, '内容管理员111', 0, '可以进行内容编辑，一般运营人员使用。', 1),
(4, 'demo', 0, '系统演示使用', 1),
(5, 'test', 0, 'test', 1);";
        $this->execute($sql);
    }

    public function down()
    {
        echo "m160108_101859_create_andinsert cannot be reverted.\n";

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
	public function upSql(){
		
		
	}
}
