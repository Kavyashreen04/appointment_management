<?php
namespace App\Controllers;
use CodeIgniter\Controller;

class Landing extends Controller
{
    public function index()
    {
        return view('landing');
    }
}
