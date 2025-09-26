<?php

namespace App\Controllers;

use App\Models\AppointmentModel;
use App\Models\DoctorModel;
use App\Models\PatientModel;
use App\Models\PatientHistoryModel;
use CodeIgniter\Controller;

class Appointments extends Controller
{
    protected $appointmentModel;
    protected $doctorModel;
    protected $patientModel;
    protected $historyModel;

    public function __construct()
    {
        $this->appointmentModel = new AppointmentModel();
        $this->doctorModel      = new DoctorModel();
        $this->patientModel     = new PatientModel();
        $this->historyModel     = new PatientHistoryModel();
    }

    // Show dashboard
    public function index()
    {
        $data['pending']   = $this->appointmentModel->getAppointmentsByStatus('Scheduled');
        $data['completed'] = $this->appointmentModel->getAppointmentsByStatus('Completed');
        $data['cancelled'] = $this->appointmentModel->getAppointmentsByStatus('Cancelled');

        return view('appointments/index', $data);
    }

    // Create or edit appointment (reschedule)
    public function create($id = null)
    {
        $data['doctors']     = $this->doctorModel->findAll();
        $data['patients']    = $this->patientModel->findAll();
        $data['appointment'] = $id ? $this->appointmentModel->find($id) : null;

        return view('appointments/create', $data);
    }

    // Create or update (reschedule) appointment
    public function store()
    {
        $post   = $this->request->getPost();
        $userId = session()->get('user_id');
        $id     = $post['id'] ?? null; // ✅ detect if we are updating

        if (strtotime($post['end_datetime']) <= strtotime($post['start_datetime'])) {
            return redirect()->back()->withInput()->with('error', 'End time must be after start time.');
        }

        // Check overlapping appointments
        $conflictQuery = $this->appointmentModel
            ->where('doctor_id', $post['doctor_id'])
            ->where('status !=', 'Cancelled')
            ->groupStart()
                ->where("start_datetime <", $post['end_datetime'])
                ->where("end_datetime >", $post['start_datetime'])
            ->groupEnd();

        if ($id) {
            $conflictQuery->where('id !=', $id); // ignore current row when updating
        }

        if ($conflictQuery->first()) {
            return redirect()->back()->withInput()->with('error', 
                'This doctor already has an appointment during the selected time.');
        }

        $data = [
            'doctor_id'           => $post['doctor_id'],
            'patient_id'          => $post['patient_id'],
            'problem_description' => $post['problem_description'],
            'start_datetime'      => $post['start_datetime'],
            'end_datetime'        => $post['end_datetime'],
            'status'              => 'Scheduled',
            'updated_by'          => $userId
        ];

        if ($id) {
            // ✅ Update existing row
            $this->appointmentModel->update($id, $data);
            session()->setFlashdata('success', 'Appointment rescheduled successfully.');
        } else {
            // ✅ Insert new row if creating fresh
            $data['created_by'] = $userId;
            $this->appointmentModel->insert($data);
            session()->setFlashdata('success', 'Appointment created successfully.');
        }

        return redirect()->to('/appointments');
    }

    // Show form before completing appointment
   public function completeForm($id)
{
    // ✅ Join doctor + patient to fetch names
    $appointment = $this->appointmentModel
        ->select('appointments.*, doctors.name as doctor_name, patients.name as patient_name')
        ->join('doctors', 'doctors.id = appointments.doctor_id')
        ->join('patients', 'patients.id = appointments.patient_id')
        ->where('appointments.id', $id)
        ->first();

    if (!$appointment) {
        return redirect()->to('/appointments')->with('error', 'Appointment not found.');
    }

    return view('appointments/complete_form', ['appointment' => $appointment]);
}


    // Mark appointment completed after form submit
    public function markCompleted($id)
    {
        $appointment = $this->appointmentModel->find($id);

        if (!$appointment) {
            return redirect()->to('/appointments')->with('error', 'Appointment not found.');
        }

        $post = $this->request->getPost();

        // ✅ Update appointment status
        $this->appointmentModel->update($id, ['status' => 'Completed']);

        // ✅ Insert into patient history
        $this->historyModel->insert([
            'patient_id'          => $appointment['patient_id'],
            'doctor_id'           => $appointment['doctor_id'],
            'appointment_id'      => $appointment['id'],
            'problem_description' => $appointment['problem_description'],
            'visit_datetime'      => date('Y-m-d H:i:s'),
            'weight'              => $post['weight'] ?? null,
            'blood_pressure'      => $post['blood_pressure'] ?? null,
            'doctor_comments'     => $post['doctor_comments'] ?? null
        ]);

        return redirect()->to('/appointments')->with('success', 'Appointment completed successfully.');
    }

    // Cancel appointment
    public function delete($id)
    {
        $this->appointmentModel->update($id, [
            'status'     => 'Cancelled',
            'deleted_by' => session()->get('user_id')
        ]);

        return redirect()->to('/appointments')->with('success', 'Appointment cancelled.');
    }

    // Export CSV
    public function exportCSV()
    {
        $appointments = $this->appointmentModel
            ->select('appointments.id, doctors.name as doctor_name, patients.name as patient_name, patients.problem_description, start_datetime, end_datetime, status')
            ->join('doctors', 'doctors.id = appointments.doctor_id')
            ->join('patients', 'patients.id = appointments.patient_id')
            ->orderBy('start_datetime', 'ASC')
            ->findAll();

        $filename = 'appointments_' . date('Y-m-d_H-i') . '.csv';

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0');

        $output = fopen('php://output', 'w');
        fputcsv($output, ['ID', 'Doctor', 'Patient', 'Problem', 'Start DateTime', 'End DateTime', 'Status']);

        foreach ($appointments as $appt) {
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
}
