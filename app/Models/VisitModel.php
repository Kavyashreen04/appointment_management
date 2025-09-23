<?php

namespace App\Models;

use CodeIgniter\Model;

class VisitModel extends Model
{
    protected $table            = 'visits';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [ 'patient_id', 'doctor_id', 'visit_datetime',
        'reason', 'weight', 'bp_systolic', 'bp_diastolic',
        'doctor_comments', 'created_by', 'updated_by', 'deleted_by'];

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

    
 public function getTrendData(int $patientId)
    {
        $visits = $this->where('patient_id', $patientId)
                       ->orderBy('visit_datetime', 'ASC')
                       ->findAll();

        $labels = $weights = $systolic = $diastolic = [];

        foreach ($visits as $v) {
            $labels[] = date('d M Y', strtotime($v['visit_datetime']));
            $weights[] = $v['weight'] !== null ? (float)$v['weight'] : null;
            $systolic[] = $v['bp_systolic'] !== null ? (int)$v['bp_systolic'] : null;
            $diastolic[] = $v['bp_diastolic'] !== null ? (int)$v['bp_diastolic'] : null;
        }

        return [
            'labels' => $labels,
            'weights' => $weights,
            'systolic' => $systolic,
            'diastolic' => $diastolic,
        ];
    }

    public function getVisitsByPatient($patientId)
    {
        return $this->select('visits.*, doctors.name as doctor_name')
                    ->join('doctors', 'doctors.id = visits.doctor_id', 'left')
                    ->where('visits.patient_id', $patientId)
                    ->orderBy('visits.visit_datetime', 'DESC')
                    ->findAll();
    }
}
