<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePatients extends Migration
{
      public function up()
    {
        $this->forge->addField([
    'id' => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],
    'name' => ['type'=>'VARCHAR','constraint'=>100],
    'gender' => ['type'=>'VARCHAR','constraint'=>10],
    'problem_description' => ['type'=>'TEXT'], // <-- Add this line
    'created_by' => ['type'=>'INT','null'=>true],
    'updated_by' => ['type'=>'INT','null'=>true],
    'deleted_by' => ['type'=>'INT','null'=>true],
    'created_at DATETIME DEFAULT CURRENT_TIMESTAMP',
    'updated_at DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP',
    'deleted_at DATETIME DEFAULT NULL',
]);
$this->forge->addKey('id', true);
$this->forge->createTable('patients');

    }

    public function down()
    {
        $this->forge->dropTable('patients');
    }
}
