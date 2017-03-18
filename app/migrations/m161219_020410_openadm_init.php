<?php

use yii\db\Migration;

class m161219_020410_openadm_init extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable("{{%system_config}}", [
            'id' => $this->primaryKey(11),
            'cfg_name' => $this->string(128)->notNull()->comment('Configuration name'),
            'cfg_value' => $this->text()->comment('Configuration value'),
            'cfg_order' => $this->integer(11)->defaultValue(0)->comment('Sorting'),
            'cfg_pid' => $this->integer(11)->defaultValue(0)->comment('Father ID'),
            'ctime' => $this->integer(11)->defaultValue(0)->comment('Create time'),
            'cfg_type' => "set('SYSTEM','USER','ROUTE','PLUGIN') NOT NULL DEFAULT 'USER' COMMENT 'SYSTEM:System Configuration,USER:User configuration,ROUTE:Routing,PLUGIN:Plugin'",
            'cfg_status' => "tinyint(4) NOT NULL DEFAULT '1' COMMENT '1 display 0 not displayed'",
            'cfg_comment' => $this->string(255)->comment('Configuration instructions'),
        ], $tableOptions);

        //索引
        $this->createIndex('{{%cfg_name}}', '{{%system_config}}', 'cfg_name', false);
        $this->createIndex('{{%cfg_pid}}', '{{%system_config}}', 'cfg_pid', false);
        $this->createIndex('{{%cfg_type}}', '{{%system_config}}', 'cfg_type', false);
        $route = json_encode(['admin/plugin-manager/<a:\w+>/<tab:\w+>'=>'admin/plugin-manager/<a>']);
        $columns = ['id','cfg_name', 'cfg_value', 'cfg_order','cfg_pid','ctime','cfg_type','cfg_status','cfg_comment'];
        $ctime = time();
        $this->batchInsert('{{%system_config}}', $columns, [
            [1,'MENU', '{"url":"#","icon":"fa fa-cogs"}', 50, 0, $ctime, 'USER', 1, 'System'],
            [2,'MENU', '{"url":"#","icon":"fa fa-cogs"}', 50, 1, $ctime, 'USER', 1, 'System settings'],
            [3,'MENU', '{"url":"#","icon":"fa fa-unlock-alt"}', 51, 1,$ctime , 'USER', 1, 'Authority management'],
            [4,'MENU', '{"url":"/admin/dashboard/main","icon":"fa fa-dashboard"}', 0, 1, $ctime, 'USER', 1, 'Control panel'],
            [5,'MENU', '{"url":"/admin/plugin-manager/local/all"}', 0, 2, $ctime, 'USER', 1, 'Plugin management'],
            [6,'MENU', '{"url":"/user/admin/index"}', 0, 2, $ctime, 'USER', 1, 'User Management'],
            [7,'MENU', '{"url":"/rbac/assignment"}', 0, 3, $ctime, 'USER', 1, 'Authorized users'],
            [8,'MENU', '{"url":"/rbac/role"}', 0, 3, $ctime, 'USER', 1, 'Roles'],
            [9,'MENU', '{"url":"/rbac/route"}', 0, 3, $ctime, 'USER', 1, 'Routes'],
            //Article 12 routing is important, delete the plug-in management function can not be properly accessed
            [10,'PLUGINMANAGER_ROUTE', $route, 0, 0, $ctime, 'ROUTE', 1, 'Plug-in management routing']
        ]);

    }

    public function safeDown()
    {
        $this->dropTable('{{%system_config}}');
    }
}
