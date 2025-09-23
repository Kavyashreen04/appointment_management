<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateVisits extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'auto_increment'=>true],
            'patient_id' => ['type'=>'INT','constraint'=>11,'unsigned'=>true],
            'doctor_id'  => ['type'=>'INT','constraint'=>11,'unsigned'=>true,'null'=>true],
            'visit_datetime' => ['type'=>'DATETIME'],
            'reason' => ['type'=>'TEXT','null'=>true],
            'weight' => ['type'=>'DECIMAL','constraint'=>'5,2','null'=>true], // kg
            'bp_systolic' => ['type'=>'INT','null'=>true],
            'bp_diastolic' => ['type'=>'INT','null'=>true],
            'doctor_comments' => ['type'=>'TEXT','null'=>true],
            'created_at' => ['type'=>'DATETIME','null'=>true],
            'updated_at' => ['type'=>'DATETIME','null'=>true],
            'deleted_at' => ['type'=>'DATETIME','null'=>true],
            'created_by' => ['type'=>'INT','null'=>true],
            'updated_by' => ['type'=>'INT','null'=>true],
            'deleted_by' => ['type'=>'INT','null'=>true],
        ]);

        $this->forge->addKey('id', true);
        // optional foreign key (ensure your DB engine supports it & patients table exists)
        //$this->forge->addForeignKey('patient_id','patients','id','CASCADE','CASCADE');
        $this->forge->createTable('visits');
    }

    public function down()
    {
        $this->forge->dropTable('visits');
    }
}
