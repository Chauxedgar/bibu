<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

require_once 'config.php';

$method = $_SERVER['REQUEST_METHOD'];
$input = json_decode(file_get_contents('php://input'), true);

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = mysqli_real_escape_string($conn, $_GET['id']);
            $query = "SELECT * FROM clientes WHERE id = $id";
            $result = mysqli_query($conn, $query);
            $data = mysqli_fetch_assoc($result);
            echo json_encode($data);
        } else {
            $query = "SELECT * FROM clientes ORDER BY id";
            $result = mysqli_query($conn, $query);
            $data = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
            echo json_encode($data);
        }
        break;
        
    case 'POST':
        $id = mysqli_real_escape_string($conn, $input['id']);
        $name = mysqli_real_escape_string($conn, $input['name']);
        $email = mysqli_real_escape_string($conn, $input['email']);
        $phone = mysqli_real_escape_string($conn, $input['phone']);
        $address = mysqli_real_escape_string($conn, $input['address']);
        
        $check = mysqli_query($conn, "SELECT id FROM clientes WHERE id = $id");
        if (mysqli_num_rows($check) > 0) {
            echo json_encode(['error' => 'El ID ya existe']);
            break;
        }
        
        $query = "INSERT INTO clientes (id, name, email, phone_number, address) 
                  VALUES ($id, '$name', '$email', '$phone', '$address')";
        
        if (mysqli_query($conn, $query)) {
            echo json_encode(['success' => 'Cliente agregado correctamente']);
        } else {
            echo json_encode(['error' => 'Error al agregar cliente: ' . mysqli_error($conn)]);
        }
        break;
        
    case 'PUT':
        parse_str(file_get_contents("php://input"), $put_vars);
        $id = mysqli_real_escape_string($conn, $put_vars['id'] ?? $_GET['id']);
        $name = mysqli_real_escape_string($conn, $put_vars['name']);
        $email = mysqli_real_escape_string($conn, $put_vars['email']);
        $phone = mysqli_real_escape_string($conn, $put_vars['phone']);
        $address = mysqli_real_escape_string($conn, $put_vars['address']);
        
        $query = "UPDATE clientes SET 
                  name = '$name', 
                  email = '$email', 
                  phone_number = '$phone', 
                  address = '$address' 
                  WHERE id = $id";
        
        if (mysqli_query($conn, $query)) {
            echo json_encode(['success' => 'Cliente actualizado correctamente']);
        } else {
            echo json_encode(['error' => 'Error al actualizar cliente']);
        }
        break;
        
    case 'DELETE':
        // Eliminar un cliente
        $id = mysqli_real_escape_string($conn, $_GET['id']);
        $query = "DELETE FROM clientes WHERE id = $id";
        
        if (mysqli_query($conn, $query)) {
            echo json_encode(['success' => 'Cliente eliminado correctamente']);
        } else {
            echo json_encode(['error' => 'Error al eliminar cliente']);
        }
        break;
        
    default:
        echo json_encode(['error' => 'Método no permitido']);
        break;
}

mysqli_close($conn);
?>