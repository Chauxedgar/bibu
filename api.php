<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type");

require_once 'config.php';

$method = $_SERVER['REQUEST_METHOD'];
$input  = json_decode(file_get_contents('php://input'), true);

// ============================================================
//  Detectar si la petición es para la tabla LIBROS
//  ?tabla=libros
// ============================================================
if (isset($_GET['tabla']) && $_GET['tabla'] === 'libros') {

    switch ($method) {

        // GET todos los libros  →  api.php?tabla=libros
        // GET un libro por ID   →  api.php?tabla=libros&id=3
        case 'GET':
            if (isset($_GET['id'])) {
                $id     = (int)$_GET['id'];
                $result = mysqli_query($conn, "SELECT * FROM libros WHERE idlibros = $id");
                echo json_encode(mysqli_fetch_assoc($result));
            } else {
                $result = mysqli_query($conn, "SELECT * FROM libros ORDER BY titulo");
                $data = [];
                while ($row = mysqli_fetch_assoc($result)) {
                    $data[] = $row;
                }
                echo json_encode($data);
            }
            break;

        // POST  →  api.php?tabla=libros   body: {titulo, autor}
        case 'POST':
            $titulo = mysqli_real_escape_string($conn, $input['titulo'] ?? '');
            $autor  = mysqli_real_escape_string($conn, $input['autor']  ?? '');

            if (!$titulo || !$autor) {
                echo json_encode(['error' => 'Título y autor son obligatorios.']);
                break;
            }

            $q = "INSERT INTO libros (titulo, autor) VALUES ('$titulo', '$autor')";
            if (mysqli_query($conn, $q)) {
                echo json_encode(['success' => 'Libro agregado correctamente.']);
            } else {
                echo json_encode(['error' => 'Error al agregar: ' . mysqli_error($conn)]);
            }
            break;

        // PUT  →  api.php?tabla=libros&id=3   body: {titulo, autor}
        case 'PUT':
            $id     = (int)($_GET['id'] ?? 0);
            $titulo = mysqli_real_escape_string($conn, $input['titulo'] ?? '');
            $autor  = mysqli_real_escape_string($conn, $input['autor']  ?? '');

            if (!$id || !$titulo || !$autor) {
                echo json_encode(['error' => 'Datos incompletos.']);
                break;
            }

            $q = "UPDATE libros SET titulo='$titulo', autor='$autor' WHERE idlibros=$id";
            if (mysqli_query($conn, $q)) {
                echo json_encode(['success' => 'Libro actualizado correctamente.']);
            } else {
                echo json_encode(['error' => 'Error al actualizar: ' . mysqli_error($conn)]);
            }
            break;

        // DELETE  →  api.php?tabla=libros&id=3
        case 'DELETE':
            $id = (int)($_GET['id'] ?? 0);

            if (!$id) {
                echo json_encode(['error' => 'ID inválido.']);
                break;
            }

            $q = "DELETE FROM libros WHERE idlibros=$id";
            if (mysqli_query($conn, $q)) {
                echo json_encode(['success' => 'Libro eliminado correctamente.']);
            } else {
                echo json_encode(['error' => 'Error al eliminar: ' . mysqli_error($conn)]);
            }
            break;

        default:
            echo json_encode(['error' => 'Método no permitido.']);
            break;
    }

    mysqli_close($conn);
    exit();
}

// ============================================================
//  CRUD de CLIENTES  (sin ?tabla=libros)
// ============================================================
switch ($method) {

    // GET todos con JOIN a libros  →  api.php
    // GET uno por ID               →  api.php?id=5
    case 'GET':
        if (isset($_GET['id'])) {
            $id     = mysqli_real_escape_string($conn, $_GET['id']);
            $result = mysqli_query($conn,
                "SELECT c.*, l.titulo, l.autor
                 FROM clientes c
                 LEFT JOIN libros l ON c.idlibros = l.idlibros
                 WHERE c.id = $id"
            );
            echo json_encode(mysqli_fetch_assoc($result));
        } else {
            $result = mysqli_query($conn,
                "SELECT c.*, l.titulo, l.autor
                 FROM clientes c
                 LEFT JOIN libros l ON c.idlibros = l.idlibros
                 ORDER BY c.id"
            );
            $data = [];
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
            echo json_encode($data);
        }
        break;

    // POST  →  api.php   body JSON: {id, name, email, phone, address, idlibros}
    case 'POST':
        $id       = mysqli_real_escape_string($conn, $input['id']      ?? '');
        $name     = mysqli_real_escape_string($conn, $input['name']    ?? '');
        $email    = mysqli_real_escape_string($conn, $input['email']   ?? '');
        $phone    = mysqli_real_escape_string($conn, $input['phone']   ?? '');
        $address  = mysqli_real_escape_string($conn, $input['address'] ?? '');
        $idlibros = !empty($input['idlibros']) ? (int)$input['idlibros'] : null;

        $check = mysqli_query($conn, "SELECT id FROM clientes WHERE id = $id");
        if (mysqli_num_rows($check) > 0) {
            echo json_encode(['error' => 'El ID ya existe.']);
            break;
        }

        $librosVal = $idlibros ? $idlibros : 'NULL';
        $q = "INSERT INTO clientes (id, name, email, phone_number, address, idlibros)
              VALUES ($id, '$name', '$email', '$phone', '$address', $librosVal)";

        if (mysqli_query($conn, $q)) {
            echo json_encode(['success' => 'Cliente agregado correctamente.']);
        } else {
            echo json_encode(['error' => 'Error al agregar: ' . mysqli_error($conn)]);
        }
        break;

    // PUT  →  api.php?id=5   body form-urlencoded
    case 'PUT':
        parse_str(file_get_contents("php://input"), $put);
        $id       = mysqli_real_escape_string($conn, $put['id']      ?? $_GET['id'] ?? '');
        $name     = mysqli_real_escape_string($conn, $put['name']    ?? '');
        $email    = mysqli_real_escape_string($conn, $put['email']   ?? '');
        $phone    = mysqli_real_escape_string($conn, $put['phone']   ?? '');
        $address  = mysqli_real_escape_string($conn, $put['address'] ?? '');
        $idlibros = !empty($put['idlibros']) ? (int)$put['idlibros'] : null;

        $librosVal = $idlibros ? $idlibros : 'NULL';
        $q = "UPDATE clientes SET
                name         = '$name',
                email        = '$email',
                phone_number = '$phone',
                address      = '$address',
                idlibros     = $librosVal
              WHERE id = $id";

        if (mysqli_query($conn, $q)) {
            echo json_encode(['success' => 'Cliente actualizado correctamente.']);
        } else {
            echo json_encode(['error' => 'Error al actualizar: ' . mysqli_error($conn)]);
        }
        break;

    // DELETE  →  api.php?id=5
    case 'DELETE':
        $id = mysqli_real_escape_string($conn, $_GET['id']);
        $q  = "DELETE FROM clientes WHERE id = $id";

        if (mysqli_query($conn, $q)) {
            echo json_encode(['success' => 'Cliente eliminado correctamente.']);
        } else {
            echo json_encode(['error' => 'Error al eliminar: ' . mysqli_error($conn)]);
        }
        break;

    default:
        echo json_encode(['error' => 'Método no permitido.']);
        break;
}

mysqli_close($conn);
?>
