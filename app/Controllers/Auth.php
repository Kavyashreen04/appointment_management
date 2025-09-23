<?php
namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\Controller;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Auth extends Controller
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        helper(['form', 'url']);
    }

    public function login()
    {
        return view('auth/login');
    }

    public function register()
    {
        return view('auth/register');
    }

    public function store() // register
    {
        $validation = \Config\Services::validation();
        $validation->setRules([
            'name' => 'required|min_length[3]',
            'email' => 'required|valid_email|is_unique[users.email]',
            'password' => 'required|min_length[6]',
            'confirm_password' => 'required|matches[password]'
        ]);

        if (!$validation->withRequest($this->request)->run()) {
            return redirect()->back()->withInput()->with('error', $validation->listErrors());
        }

        $this->userModel->save([
            'name' => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT)
        ]);

        return redirect()->to('/login')->with('success', 'Registration successful. Please login.');
    }

public function loginJWT()
{
    $session = session();

    $email = $this->request->getPost('email');
    $password = $this->request->getPost('password');

    $user = $this->userModel->where('email', $email)->first();

    if (!$user || !password_verify($password, $user['password'])) {
        return redirect()->back()->with('error', 'Invalid credentials');
    }

    // Create JWT
    $key = getenv('JWT_SECRET');
    $payload = [
        'id' => $user['id'],
        'email' => $user['email'],
        'iat' => time(),
        'exp' => time() + 3600
    ];

    $token = \Firebase\JWT\JWT::encode($payload, $key, 'HS256');

    // Store JWT in session
    // Store JWT and user data in session
$session->set([
    'jwt_token' => $token,
    'user'      => $user,
    'user_id'   => $user['id'],   // ✅ store user ID explicitly
    'logged_in' => true           // ✅ useful for auth checks
]);


    // Redirect to dashboard
    return redirect()->to('/dashboard');
}


    public function logout()
    {
        session()->destroy();
        return redirect()->to('/')->with('success', 'Logged out successfully');
    }
}
