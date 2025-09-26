<?php

namespace App\Models;

use CodeIgniter\Model;

class AppointmentModel extends Model
{
    protected $table            = 'appointments';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true;
    protected $protectFields    = true;
    protected $allowedFields    = ['doctor_id','patient_id','status','created_at','updated_at','deleted_at', 'problem_description',  'start_datetime', 'end_datetime',
'created_by', 'updated_by', 'deleted_by'];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];


        public function getAppointmentsByStatus(string $status)
    {
        return $this->select('appointments.*, doctors.name as doctor_name, patients.name as patient_name, patients.problem_description')
                    ->join('doctors', 'doctors.id = appointments.doctor_id')
                    ->join('patients', 'patients.id = appointments.patient_id')
                    ->where('appointments.status', $status)
                    ->orderBy('appointments.start_datetime', 'ASC')
                    ->findAll();
    }
}
