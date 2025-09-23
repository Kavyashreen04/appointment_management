<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddProblemDescriptionToAppointments extends Migration
{
     public function up()
    {
        $fields = [
            'problem_description' => [
                'type' => 'TEXT',
                'null' => true,
            ],
        ];
        $this->forge->addColumn('appointments', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('appointments', 'problem_description');
    }
}
