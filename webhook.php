<?php

/*
* Simple validation by user agent
*/
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
if (stripos($userAgent, 'Apps Script') === false) {
    http_response_code(403);
    die('Acceso denegado.');
}


// $data['id'] = "121211231-1223";
// $data['message'] = "Pepe A. Rios N. te envió un pago por S/ 5. El cód. de seguridad es: 541";


if ( $_SERVER['REQUEST_METHOD'] === 'POST') {
    // Captura los datos de la solicitud POST
    $data = $_POST;

    /**
    * Logs
    */
    $dataJson = json_encode($data, JSON_PRETTY_PRINT);
    $logFile = 'log.log';
    $logEntry = date('Y-m-d H:i:s') . " - Data: \n" . $dataJson . "\n\n";
    file_put_contents($logFile, $logEntry, FILE_APPEND);
    echo 'Datos registrados en el archivo log.';

    // send mail task 2
    error_log("Debugging inicio");
    error_log(print_r($data, true)); // Usa print_r para obtener una representación legible del array/objeto
    error_log("Debugging fin");


    /**
    * Creacion de archivo JSON
    */
    echo "<pre>";
    print_r($data);
    echo "</pre>";

    // Nombre del archivo basado en el ID
    $filename = $data['id'] . '.json';
    $content = $data['message'] . PHP_EOL; // Agrega salto de línea
    file_put_contents($filename, $content, FILE_APPEND);

} else {
    echo 'No se enviaron datos POST.';
    error_log("No se enviaron datos POST.");
}

