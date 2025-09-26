<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePatientHistory extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'                => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'patient_id'        => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'doctor_id'         => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'appointment_id'    => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'problem_description'=> ['type' => 'TEXT', 'null' => true],
            'visit_datetime'    => ['type' => 'DATETIME', 'null' => true],
            'weight'            => ['type' => 'FLOAT', 'null' => true],
            'blood_pressure'    => ['type' => 'VARCHAR', 'constraint' => 20, 'null' => true],
            'doctor_comments'   => ['type' => 'TEXT', 'null' => true],
            'created_at'        => ['type' => 'DATETIME', 'null' => true, 'default' => null],
            'updated_at'        => ['type' => 'DATETIME', 'null' => true, 'default' => null],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('patient_id', 'patients', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('doctor_id', 'doctors', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('appointment_id', 'appointments', 'id', 'CASCADE', 'CASCADE');

        $this->forge->createTable('patient_history');
    }

    public function down()
    {
        $this->forge->dropTable('patient_history');
    }
}
