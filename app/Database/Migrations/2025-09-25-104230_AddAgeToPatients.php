<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAgeToPatients extends Migration
{
    public function up()
    {
        $this->forge->addColumn('patients',[
            'age'=>['type'=>'INT','constraint'=>3 ,'null'=>true]]
        );
    }

    public function down()
    {
         $this->forge->dropColumn('patients', 'age');
    }
}
