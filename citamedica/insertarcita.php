<?php

// Configuración de la base de datos
$host = 'localhost';
$db = 'citamedica';
$user = 'root';
$pass = '';

// Conexión a la base de datos
$conexion = new mysqli($host, $user, $pass, $db);

// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión a la base de datos: " . $conexion->connect_error);
}

// Endpoint para el registro de citas
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);

    // Validar datos
    if (empty($data['paciente']) || empty($data['fecha']) || empty($data['medico'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Faltan datos obligatorios']);
        exit;
    }

    // Insertar cita en la base de datos
    $paciente = $conexion->real_escape_string($data['paciente']);
    $fecha = $conexion->real_escape_string($data['fecha']);
    $medico = $conexion->real_escape_string($data['medico']);

    $query = "INSERT INTO citas_medicas (paciente, fecha, medico) VALUES ('$paciente', '$fecha', '$medico')";

    if ($conexion->query($query) === TRUE) {
        http_response_code(201);
        echo json_encode(['mensaje' => 'Cita médica registrada exitosamente']);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Error al registrar la cita médica']);
    }

    // Cerrar la conexión
    $conexion->close();
} else {
    http_response_code(405);
    echo json_encode(['error' => 'Método no permitido']);
}
