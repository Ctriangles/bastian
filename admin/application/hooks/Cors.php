<?php
class Cors {
    public function allow() {
        $allowed_origins = array(
            'http://localhost:5173',
            'https://pixelwipe.com'
        );

        $origin = isset($_SERVER['HTTP_ORIGIN']) ? $_SERVER['HTTP_ORIGIN'] : '';
        
        if (in_array($origin, $allowed_origins)) {
            header('Access-Control-Allow-Origin: ' . $origin);
        }

        header('Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT');
        header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Request-Type, X-Client-Version, X-Platform');
        header('Access-Control-Allow-Credentials: true');
        
        if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
            header('Access-Control-Max-Age: 1728000');
            header('Content-Length: 0');
            header('Content-Type: text/plain; charset=UTF-8');
            exit(0);
        }
    }
}

// for production
// <?php
// class Cors {
//     public function allow() {
//         if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
//             header('Access-Control-Allow-Origin: http://localhost:5173, https://pixelwipe.com');
//             header('Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT');
//             header('Access-Control-Allow-Headers: Content-Type, Authorization');
//             header('Access-Control-Max-Age: 1728000');
//             header('Content-Length: 0');
//             header('Content-Type: text/plain; charset=UTF-8');
//             exit(0);
//         }

//         header('Access-Control-Allow-Origin: http://localhost:5173, https://pixelwipe.com');
//         header('Access-Control-Allow-Methods: GET, POST, OPTIONS, DELETE, PUT');
//         header('Access-Control-Allow-Headers: Content-Type, Authorization');
//     }
// }