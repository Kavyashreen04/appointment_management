<?php
namespace App\Controllers;

use App\Models\DoctorModel;
use CodeIgniter\Controller;

class Doctors extends Controller
{
    protected $doctorModel;

    public function __construct()
    {
        $this->doctorModel = new DoctorModel();
    }

    // List doctors
    public function index()
    {
        $doctors = $this->doctorModel->findAll();
        return view('doctors/index', ['doctors' => $doctors]);
    }

    // Show create form
    public function create()
    {
        return view('doctors/form');
    }

    // Store new doctor
  public function store()
{
    $validation =  \Config\Services::validation();
    $validation->setRules([
        'name' => 'required|min_length[3]',
        'expertise' => 'required',
        'gender' => 'required'
    ]);

    if (!$validation->withRequest($this->request)->run()) {
        return redirect()->back()->withInput()->with('error', $validation->listErrors());
    }

    $this->doctorModel->save([
        'name' => $this->request->getPost('name'),
        'expertise' => $this->request->getPost('expertise'),
        'gender' => $this->request->getPost('gender'),
        'created_by' => session()->get('user')['id']
    ]);

    return redirect()->to('/doctors')->with('success', 'Doctor added successfully.');
}


    // Show edit form
    public function edit($id)
    {
        $doctor = $this->doctorModel->find($id);
        return view('doctors/form', ['doctor' => $doctor]);
    }

    // Update doctor
    public function update($id)
    {
        $validation =  \Config\Services::validation();
        $validation->setRules([
            'name' => 'required|min_length[3]',
            'expertise' => 'required',
            'gender' => 'required'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('error', $validation->listErrors());
        }

        $this->doctorModel->update($id, [
            'name' => $this->request->getPost('name'),
            'expertise' => $this->request->getPost('expertise'),
            'gender' => $this->request->getPost('gender'),
           'updated_by' => session()->get('user')['id']

        ]);

        return redirect()->to('/doctors')->with('success', 'Doctor updated successfully.');
    }

    // Delete doctor
    public function delete($id)
    {
        $this->doctorModel->update($id, [
            'deleted_by' => session()->get('user')['id']

        ]);
        $this->doctorModel->delete($id); // Soft delete
        return redirect()->to('/doctors')->with('success', 'Doctor deleted.');
    }
}
