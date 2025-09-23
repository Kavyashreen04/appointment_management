<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtAuth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
{
    $session = session();
    $token = $session->get('jwt_token');

    if (!$token) {
        return redirect()->to('/login')->with('error', 'Please login first.');
    }

    try {
        $key = getenv('JWT_SECRET');
        $decoded = \Firebase\JWT\JWT::decode($token, new Key($key, 'HS256'));
        $request->user = [
            'id' => $decoded->id,
            'email' => $decoded->email
        ];
    } catch (\Exception $e) {
        return redirect()->to('/login')->with('error', 'Session expired. Please login again.');
    }
}


    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // No post-processing needed
    }
}
