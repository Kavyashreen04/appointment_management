<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDoctors extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],
            'name' => ['type'=>'VARCHAR','constraint'=>150],
            'expertise' => ['type'=>'VARCHAR','constraint'=>255],
            'gender' => ['type'=>'ENUM','constraint'=>['Male','Female','Other'],'default'=>'Other'],
            'created_at' => ['type'=>'DATETIME','null'=>true],
            'updated_at' => ['type'=>'DATETIME','null'=>true],
            'deleted_at' => ['type'=>'DATETIME','null'=>true],
            'created_by' => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'null'=>true],
            'updated_by' => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'null'=>true],
            'deleted_by' => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('doctors');
    }

    public function down()
    {
        $this->forge->dropTable('doctors');
    }
}
