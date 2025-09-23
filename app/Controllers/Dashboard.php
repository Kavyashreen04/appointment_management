<?php

namespace App\Controllers;

use App\Models\AppointmentModel;
use CodeIgniter\Controller;

class Dashboard extends Controller
{
    protected $appointmentModel;

    public function __construct()
    {
        $this->appointmentModel = new AppointmentModel();
    }

public function index()
{
    $range = $this->request->getGet('range') ?? 'today';

    // Filter appointments for table display
    $appointments = $this->filterAppointments($range);

    // Counts filtered by range
    $pendingCount   = $this->appointmentModel->countByStatusAndRange('scheduled', $range);
    $completedCount = $this->appointmentModel->countByStatusAndRange('completed', $range);
    $canceledCount  = $this->appointmentModel->countByStatusAndRange('cancelled', $range);
    $totalCount     = $this->appointmentModel->countByStatusAndRange(null, $range);

    $data = [
        'doctorCount'       => model('DoctorModel')->countAllResults(),
        'patientCount'      => model('PatientModel')->countAllResults(),
        'appointmentCount'  => count($appointments), // for table display
        'pendingCount'      => $pendingCount,
        'completedCount'    => $completedCount,
        'canceledCount'     => $canceledCount,
        'totalCount'        => $totalCount,
        'recentAppointments'=> $appointments,
        'selectedRange'     => $range
    ];

    return view('dashboard/index', $data);
}


 private function filterAppointments(string $range)
{
    $builder = $this->appointmentModel->select([
        'appointments.*',
        'doctors.name as doctor_name',
        'patients.name as patient_name',
        'patients.problem_description as problem_description' , 
        'appointments.status as status' 
    ])
    ->join('doctors', 'doctors.id = appointments.doctor_id')
    ->join('patients', 'patients.id = appointments.patient_id')
    // ->where('appointments.status','completed');
            ;
    switch ($range) {
        case 'today':
            $builder->where('DATE(appointments.start_datetime)', date('Y-m-d'));
            break;

        case 'week':
            $builder->where('YEARWEEK(appointments.start_datetime, 1)', date('oW'));
            break;

        case 'month':
            $builder->where('MONTH(appointments.start_datetime)', date('m'))
                    ->where('YEAR(appointments.start_datetime)', date('Y'));
            break;

        case '3months':
            $builder->where('appointments.start_datetime >=', date('Y-m-d H:i:s', strtotime('-3 months')));
            break;
    }

    return $builder->orderBy('appointments.start_datetime', 'DESC')->findAll();
}

}
