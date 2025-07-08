<?php
class Cors {
    public function allow() {
        // Get the origin from the request
        $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';

        // List of allowed origins
        $allowedOrigins = [
            'http://localhost:5173',
            'http://localhost:5174',
            'https://pixelwipe.com',
            'https://bastianhospitality.com',
            'https://bastian.ninetriangles.com'
        ];

        // Check if the origin is allowed
        if (in_array($origin, $allowedOrigins)) {
            $allowOrigin = $origin;
        } else {
            // For development, allow localhost with any port
            if (preg_match('/^http:\/\/localhost:\d+$/', $origin)) {
                $allowOrigin = $origin;
            } else {
                $allowOrigin = 'http://localhost:5173'; // Default fallback
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header('Access-Control-Allow-Origin: ' . $allowOrigin);
            header('Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT');
            header('Access-Control-Allow-Headers: Content-Type, Authorization');
            header('Access-Control-Max-Age: 1728000');
            header('Content-Length: 0');
            header('Content-Type: text/plain; charset=UTF-8');
            exit(0);
        }

        header('Access-Control-Allow-Origin: ' . $allowOrigin);
        header('Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT');
        header('Access-Control-Allow-Headers: Content-Type, Authorization');
    }
}