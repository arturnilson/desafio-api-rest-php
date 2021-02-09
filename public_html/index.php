<?php
header('Content-Type: application/json; charset=utf-8');

require_once '../vendor/autoload.php';

// api/$ Metodo $/1
if ($_GET['url']) {
    $url = explode('/', $_GET['url']);

    if ($url[0] === 'api') {
        array_shift($url);

        $service = 'App\Services\\' . ucfirst($url[0] . 'Service');
        array_shift($url);


        $method = strtolower($_SERVER['REQUEST_METHOD']);

        try {
            $response =  call_user_func_array([new $service, $method], $url);

            echo json_encode(['status' => 'success', 'data' => $response]);
        } catch (\Exception $e) {
            http_response_code(404);
            echo json_encode(['status' => 'error', 'data' => $e->getMessage()], JSON_UNESCAPED_UNICODE);
        }
    }
}
