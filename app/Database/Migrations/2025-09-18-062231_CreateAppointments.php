<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAppointments extends Migration
{
     public function up()
    {
        $this->forge->addField([
            'id' => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],
            'doctor_id' => ['type'=>'INT','constraint'=>11,'unsigned'=>true],
            'patient_id' => ['type'=>'INT','constraint'=>11,'unsigned'=>true],
            'start_datetime' => ['type'=>'DATETIME'],
            'end_datetime' => ['type'=>'DATETIME'],
            'status' => ['type'=>'ENUM','constraint'=>['Scheduled','Completed','Cancelled'],'default'=>'Scheduled'],
            'created_at' => ['type'=>'DATETIME','null'=>true],
            'updated_at' => ['type'=>'DATETIME','null'=>true],
            'deleted_at' => ['type'=>'DATETIME','null'=>true],
            'created_by' => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'null'=>true],
            'updated_by' => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'null'=>true],
            'deleted_by' => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'null'=>true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('appointments');
    }

    public function down()
    {
        $this->forge->dropTable('appointments');
    }
}
