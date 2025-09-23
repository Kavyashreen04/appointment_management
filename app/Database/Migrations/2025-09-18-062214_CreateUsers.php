<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsers extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],
            'name' => ['type'=>'VARCHAR','constraint'=>150],
            'email' => ['type'=>'VARCHAR','constraint'=>150],
            'password'=> ['type'=>'VARCHAR','constraint'=>255],
            'created_at' => ['type'=>'DATETIME','null'=>true],
            'updated_at' => ['type'=>'DATETIME','null'=>true],
            'deleted_at' => ['type'=>'DATETIME','null'=>true],
            'created_by' => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'null'=>true],
            'updated_by' => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'null'=>true],
            'deleted_by' => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addKey('email');
        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
