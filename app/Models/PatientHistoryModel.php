<?php

namespace App\Models;

use CodeIgniter\Model;

class PatientHistoryModel extends Model
{
    protected $table            = 'patient_history';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [ 'patient_id', 'doctor_id', 'appointment_id',
        'problem_description', 'visit_datetime',
        'weight', 'blood_pressure', 'doctor_comments',
        'created_at', 'updated_at'];

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

   public function getVisitsByPatient($patientId)
{
    return $this->select('patient_history.*, doctors.name as doctor_name')
                ->join('doctors', 'doctors.id = patient_history.doctor_id')
                ->where('patient_history.patient_id', $patientId)
                ->orderBy('visit_datetime', 'DESC')
                ->findAll();
}

}
