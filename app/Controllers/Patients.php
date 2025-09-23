<?php
namespace App\Controllers;

use App\Models\PatientModel;
use CodeIgniter\Controller;
use App\Models\VisitModel;

class Patients extends Controller
{
    protected $patientModel;
      protected $visitModel;

   public function __construct()
{
    $this->patientModel = new PatientModel();
    $this->visitModel   = new VisitModel();
}
  

    public function index()
    {
        $patients = $this->patientModel->findAll();
        return view('patients/index', ['patients' => $patients]);
    }

    public function create()
    {
        return view('patients/form');
    }

    public function store()
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required|min_length[3]',
            'gender' => 'required',
            'problem_description' => 'required'
        ]);

         $user = session()->get('user');
        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('error', $validation->listErrors());
        }

        $this->patientModel->save([
            'name' => $this->request->getPost('name'),
            'gender' => $this->request->getPost('gender'),
            'problem_description' => $this->request->getPost('problem_description'),
    'created_by' => session()->get('user')['id']

        ]);

        return redirect()->to('/patients')->with('success', 'Patient added successfully.');
    }

    public function edit($id)
    {
        $patient = $this->patientModel->find($id);
        return view('patients/form', ['patient' => $patient]);
    }

    public function update($id)
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required|min_length[3]',
            'gender' => 'required',
            'problem_description' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('error', $validation->listErrors());
        }

        $this->patientModel->update($id, [
            'name' => $this->request->getPost('name'),
            'gender' => $this->request->getPost('gender'),
            'problem_description' => $this->request->getPost('problem_description'),
            'updated_by' => session()->get('user')['id']

        ]);

        return redirect()->to('/patients')->with('success', 'Patient updated successfully.');
    }

    public function delete($id)
    {
        $this->patientModel->update($id, [
        'deleted_by' => session()->get('user')['id']

        ]);
        $this->patientModel->delete($id); // Soft delete
        return redirect()->to('/patients')->with('success', 'Patient deleted.');
    }

    /**
 * Show patient dashboard/profile with visits and trend data
 */
public function profile($id)
{
    $patient = $this->patientModel->find($id);
    if (!$patient) {
        throw new \CodeIgniter\Exceptions\PageNotFoundException("Patient not found");
    }

    $visitModel = new \App\Models\VisitModel();
    $visits = $visitModel->getVisitsByPatient($id);

    $data = [
        'patient' => $patient,
        'visits'  => $visits
    ];

    return view('patients/profile', $data);
}


}
