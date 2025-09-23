<?php

namespace App\Controllers;

use App\Models\AppointmentModel;
use App\Models\DoctorModel;
use App\Models\PatientModel;
use CodeIgniter\Controller;

class Appointments extends Controller
{
    protected $appointmentModel;
    protected $doctorModel;
    protected $patientModel;
    

    public function __construct()
    {
        $this->appointmentModel = new AppointmentModel();
        $this->doctorModel      = new DoctorModel();
        $this->patientModel     = new PatientModel();
    }

    // index() unchanged if you already have it
    public function index()
    {
        $data['pending']   = $this->appointmentModel->getAppointmentsByStatus('scheduled');
        $data['completed'] = $this->appointmentModel->getAppointmentsByStatus('completed');
        $data['cancelled'] = $this->appointmentModel->getAppointmentsByStatus('cancelled');

        return view('appointments/index', $data);
    }

    // Show create/reschedule form
public function create($id = null)
{
    $data['doctors']  = $this->doctorModel->findAll();
    $data['patients'] = $this->patientModel->findAll();
    $data['appointment'] = null;

    if ($id) {
        $appointment = $this->appointmentModel->find($id);
        if ($appointment) {
            $data['appointment'] = $appointment;
        }
    }

    return view('appointments/create', $data);
}

// Store new or reschedule
public function store($id = null)
{
    $post = $this->request->getPost();
    $userId = session()->get('user_id'); 

    // Validation: End time must be after start time
    if (strtotime($post['end_datetime']) <= strtotime($post['start_datetime'])) {
        return redirect()->back()->withInput()->with('error', 'End time must be after start time.');
    }

    // ✅ Conflict check: Prevent booking overlapping appointments for same doctor
    $conflictQuery = $this->appointmentModel
        ->where('doctor_id', $post['doctor_id'])
        ->where('status !=', 'cancelled') // ignore cancelled appointments
        ->groupStart()
            ->where("start_datetime <", $post['end_datetime'])
            ->where("end_datetime >", $post['start_datetime'])
        ->groupEnd();

    if ($id) {
        // Exclude current appointment if updating
        $conflictQuery->where('id !=', $id);
    }

    $conflict = $conflictQuery->first();

    if ($conflict) {
        return redirect()->back()->withInput()->with('error', 
            'This doctor already has an appointment during the selected time.');
    }

    // Prepare data for insert/update
    $data = [
        'doctor_id' => $post['doctor_id'],
        'patient_id' => $post['patient_id'],
        'problem_description' => $post['problem_description'],
        'start_datetime' => $post['start_datetime'],
        'end_datetime' => $post['end_datetime'],
        'status' => 'scheduled'
    ];

    if ($id) {
        $data['updated_by'] = $userId;
        $data['updated_at'] = date('Y-m-d H:i:s');
        $this->appointmentModel->update($id, $data);
        session()->setFlashdata('success', 'Appointment rescheduled successfully.');
    } else {
        $data['created_by'] = $userId;
        $data['created_at'] = date('Y-m-d H:i:s');
        $this->appointmentModel->insert($data);
        session()->setFlashdata('success', 'Appointment created successfully.');
    }

    return redirect()->to('/appointments');
}


    public function markCompleted($id)
    {
        $this->appointmentModel->update($id, ['status' => 'completed']);
        

        return redirect()->to('/appointments')->with('success', 'Appointment marked as completed.');
    }

    public function delete($id)
{
    $userId = session()->get('user_id');

    $this->appointmentModel->update($id, [
        'status'     => 'cancelled',
        'deleted_by' => $userId,
        'deleted_at' => date('Y-m-d H:i:s')
    ]);

    return redirect()->to('/appointments')->with('success', 'Appointment cancelled.');
}



    public function exportCSV()
{
    $appointments = $this->appointmentModel
                         ->select('appointments.id, doctors.name as doctor_name, patients.name as patient_name, patients.problem_description, start_datetime, end_datetime, status')
                         ->join('doctors', 'doctors.id = appointments.doctor_id')
                         ->join('patients', 'patients.id = appointments.patient_id')
                         ->orderBy('start_datetime', 'ASC')
                         ->findAll();

    // CSV filename
    $filename = 'appointments_' . date('Y-m-d_H-i') . '.csv';

    // Set headers to download CSV
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment;filename="'.$filename.'"');
    header('Cache-Control: max-age=0');

    $output = fopen('php://output', 'w');

    // Column headers
    fputcsv($output, ['ID', 'Doctor', 'Patient', 'Problem', 'Start DateTime', 'End DateTime', 'Status']);

    // Loop through appointments
    foreach($appointments as $appt) {
        fputcsv($output, [
            $appt['id'],
            $appt['doctor_name'],
            $appt['patient_name'],
            $appt['problem_description'],
            $appt['start_datetime'],
            $appt['end_datetime'],
            $appt['status']
        ]);
    }

    fclose($output);
    exit();
}



public function doctorsWithAppointments()
{
    $db = \Config\Database::connect();

    // Get all doctors
    $doctors = $db->table('doctors')->get()->getResultArray();

    $result = [];

    foreach ($doctors as $doctor) {
        // Fetch appointments for this doctor
        $appointments = $db->table('appointments')
            ->select('appointments.*, patients.name as patient_name')
            ->join('patients', 'patients.id = appointments.patient_id', 'left')
            ->where('appointments.doctor_id', $doctor['id'])
            ->orderBy('appointments.start_datetime', 'DESC')
            ->get()
            ->getResultArray();

        $result[] = [
            'doctor' => $doctor,
            'appointments' => $appointments
        ];
    }

    return $this->response->setJSON([
        'status' => 'success',
        'data' => $result
    ]);
}

}
