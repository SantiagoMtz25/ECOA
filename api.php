<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST, GET');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once 'config.php';

$method = $_SERVER['REQUEST_METHOD'];

$database = new Database();
$db = $database->connect();

// Get 'type' and 'matricula' values from the query string
$type = isset($_GET['type']) ? $_GET['type'] : '';
$matricula = isset($_GET['matricula']) ? $_GET['matricula'] : '';
$crn = isset($_GET['crn']) ? $_GET['crn'] : '';
error_log("type: " . $type);
error_log("matricula: " . $matricula);
error_log("crn: " . $crn);

switch ($method) {
    
    case 'GET':
        if ($type == 'crn_por_matricula_E') {
            // Get CRN by matricula
            $query = "CALL crn_por_matricula_E(:matricula)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':matricula', $matricula);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(array('data' => $result));
        } elseif ($type == 'escoger_encuesta') {
            if (!empty($matricula) && !empty($crn)) {
                // Call escoger_encuesta with matricula and crn
                $query = "CALL escoger_encuesta(:matricula, :crn)";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':matricula', $matricula);
                $stmt->bindParam(':crn', $crn);
                $stmt->execute();
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                echo json_encode(array('data' => $result));
            } else {
                echo json_encode(array('message' => 'Matricula and CRN values are required for escoger_encuesta.'));
            }
        }
        elseif ($type == 'nominas_por_crn') {
            $query = "call nominas_por_crn(:crn)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':crn', $crn);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            echo json_encode(array('data' => $result));

            
        } else {
            // Handle other types or default case
            echo json_encode(array('message' => 'Tipo de solicitud GET no válido.'));
        }

        break;

    case 'POST':
        $data = json_decode(file_get_contents("php://input"));

        if (isset($data->type) && $data->type == 'actualizar_respuesta') {
            
            // Call actualizar_respuesta function
            $query = "CALL actualizar_respuesta(:ID_matricula, :ID_pregunta, :nueva_resp, :ID_encuesta, :ID_crn, :ID_nomina, :crn_nomina)";
            $stmt = $db->prepare($query);

            $stmt->bindParam(':ID_matricula', $data->ID_matricula);
            $stmt->bindParam(':ID_pregunta', $data->ID_pregunta);
            $stmt->bindParam(':nueva_resp', $data->nueva_resp);
            $stmt->bindParam(':ID_encuesta', $data->ID_encuesta);
            $stmt->bindParam(':ID_crn', $data->ID_crn);
            $stmt->bindParam(':ID_nomina', $data->ID_nomina);
            $stmt->bindParam(':crn_nomina', $data->crn_nomina);

            if ($stmt->execute()) {
                echo json_encode(array('message' => 'Respuesta actualizada correctamente.'));
            } else {
                echo json_encode(array('message' => 'Error al actualizar la respuesta.'));
            }
        } else {
            echo json_encode(array('message' => 'Tipo de solicitud POST no válido.'));
        }
        
        break;
}
?>