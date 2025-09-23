<?php
namespace App\Libraries;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JwtHelper
{
    private static $key = "your_super_secret_key"; // change this to a strong secret
    private static $algo = 'HS256';

    public static function generateToken($payload, $expire = 3600)
    {
        $issuedAt = time();
        $expireAt = $issuedAt + $expire;

        $data = [
            'iat' => $issuedAt,
            'exp' => $expireAt,
            'data' => $payload
        ];

        return JWT::encode($data, self::$key, self::$algo);
    }

    public static function validateToken($token)
    {
        try {
            $decoded = JWT::decode($token, new Key(self::$key, self::$algo));
            return $decoded->data;
        } catch (\Exception $e) {
            return false;
        }
    }
}
