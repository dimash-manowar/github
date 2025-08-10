<?php
class Admin extends Controller
{
    public function __construct()
    {
        $this->model = new AdminModel();

        parent::__construct();
        requireRole(['admin']); // Solo admins
    }
    public function index()
    {
        $mensajes = '';
        $data = [
            'page_title' => 'Administración de Orion3D',
            'mensajes' => $mensajes,
            'page_functions_js' => 'sidebar.js',
            'page_functions_js' => 'admin.js'

        ];
        $this->view('Admin/index', $data);
    }

    public function mensajes()
    {
        $mensajes = $this->model->obtenerMensajes();

        $data = [
            'page_title' => 'Gestión de Mensajes',
            'mensajes'   => $mensajes
        ];

        $this->view('Admin/mensajes', $data);
    }
    public function publicaciones()
    {
        $publicaciones = $this->model->obtenerPublicaciones();

        $data = [
            'page_title' => 'Gestor de Publicaciones',
            'publicaciones' => $publicaciones,
            'page_functions_js' => "publicaciones.js"
        ];

        $this->view('Admin/publicaciones', $data);
    }
    public function usuarios()
    {
        $data = [
            'page_title' => 'Gestión de Usuarios'
        ];
        $this->view('Admin/usuarios', $data);
    }

    // Marcar mensaje como leído
    public function marcarLeido($id)
    {
        $res = $this->model->marcarLeido(intval($id));
        echo json_encode([
            'success' => $res,
            'message' => $res ? 'Mensaje marcado como leído' : 'No se pudo actualizar'
        ]);
    }

    // Eliminar mensaje
    public function eliminarMensaje($id)
    {
        $res = $this->model->eliminarMensaje(intval($id));
        echo json_encode([
            'success' => $res,
            'message' => $res ? 'Mensaje eliminado' : 'No se pudo eliminar'
        ]);
    }
    public function eliminarPublicacion($id)
    {
        $res = $this->model->eliminarPublicacion($id);
        echo json_encode(['success' => $res, 'message' => $res ? 'Publicación eliminada' : 'No se pudo eliminar']);
    }

    public function publicar($id)
    {
        $res = $this->model->cambiarEstado($id, 1);
        echo json_encode(['success' => $res, 'message' => $res ? 'Publicada' : 'Error']);
    }

    public function despublicar($id)
    {
        $res = $this->model->cambiarEstado($id, 0);
        echo json_encode(['success' => $res, 'message' => $res ? 'Ocultada' : 'Error']);
    }
    public function perfil()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: " . BASE_URL . "Auth");
            exit;
        }

        $data['page_title'] = "Editar Perfil - Orion3D";
        $data['usuario'] = $_SESSION['user'];
        $data['page_functions_js'] = 'perfil.js';

        $this->view('Admin/perfil', $data);
    }

    public function actualizar()
    {
        if (!isset($_SESSION['user'])) {
            header("Location: " . BASE_URL . "Auth");
            exit;
        }

        $id = $_SESSION['user']['id'];
        $nombre = trim($_POST['nombre']);
        $apellido = trim($_POST['apellido']);
        $email = trim($_POST['email']);
        $password = $_POST['password'];
        $nuevaFoto = null;

        if (!empty($_FILES['foto']['name']) && $_FILES['foto']['error'] === 0) {
            $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
            $nuevaFoto = uniqid('user_') . '.' . $ext;
            move_uploaded_file($_FILES['foto']['tmp_name'], 'Assets/imagen/users/' . $nuevaFoto);
        }

        $passwordHash = empty($password) ? null : password_hash($password, PASSWORD_DEFAULT);

        $actualizado = $this->model->actualizarPerfil($id, $nombre, $apellido, $email, $passwordHash, $nuevaFoto);

        if ($actualizado) {
            // Refrescar sesión
            $_SESSION['user'] = $this->model->getById($id);

            $_SESSION['alert'] = [
                'icon' => 'success',
                'title' => 'Perfil actualizado',
                'text' => 'Tus datos se han guardado correctamente.'
            ];
        } else {
            $_SESSION['alert'] = [
                'icon' => 'error',
                'title' => 'Error',
                'text' => 'Hubo un problema al actualizar tu perfil.'
            ];
        }

        header("Location: " . BASE_URL . "Perfil");
        exit;
    }
    public function preguntas()
    {
        $this->loadModel('AdminModel');
        $estado  = $_GET['estado'] ?? null;
        $buscar  = $_GET['q'] ?? null;
        $lista   = $this->model->obtenerPreguntasQnA($estado ?: null, $buscar ?: null);

        $data = [
            'page_title' => 'Mensajes de Cursos (Q&A)',
            'qna'        => $lista,
            'page_functions_js' => 'adminPreguntas.js'
        ];
        $this->view('Admin/preguntas', $data);
    }

    public function verQna($id)
    {
        if (!isset($_SESSION['user'])) {
            http_response_code(401);
            exit;
        }
        $this->loadModel('AdminModel');
        $hilo = $this->model->obtenerHiloQnA((int)$id);
        header('Content-Type: application/json');
        echo json_encode($hilo);
    }

    public function responderQna()
    {
        // Requisitos básicos
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SESSION['user'])) {
            http_response_code(401);
            exit;
        }
        if (!csrf_verify($_POST['csrf'] ?? '')) {
            http_response_code(419);
            echo json_encode(['success' => false, 'msg' => 'CSRF inválido o caducado']);
            return;
        }

        $preguntaId = (int)($_POST['pregunta_id'] ?? 0);
        $html       = trim($_POST['contenido_html'] ?? '');

        if ($preguntaId <= 0 || $html === '') {
            http_response_code(400);
            echo json_encode(['success' => false, 'msg' => 'Datos inválidos']);
            return;
        }

        // Sanitizar HTML (whitelist básica)
        $html = strip_tags($html, '<p><b><strong><i><em><u><ul><ol><li><br><a><code><pre><img>');
        $html = preg_replace('/on\w+="[^"]*"/i', '', $html);                           // quitar onClick, onLoad, etc.
        $html = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $html);         // quitar <script>

        // Procesar imagen (opcional)
        $imgPath = null;
        if (!empty($_FILES['imagen']['name']) && $_FILES['imagen']['error'] === 0) {
            $ext = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) {
                echo json_encode(['success' => false, 'msg' => 'Formato de imagen inválido']);
                return;
            }
            if ($_FILES['imagen']['size'] > 2 * 1024 * 1024) {
                echo json_encode(['success' => false, 'msg' => 'La imagen debe pesar < 2MB']);
                return;
            }
            @mkdir('Assets/imagen/qna_respuestas/', 0775, true);
            $imgName = uniqid('rqa_') . '.' . $ext;
            if (!move_uploaded_file($_FILES['imagen']['tmp_name'], 'Assets/imagen/qna_respuestas/' . $imgName)) {
                echo json_encode(['success' => false, 'msg' => 'No se pudo guardar la imagen']);
                return;
            }
            $imgPath = 'Assets/imagen/qna_respuestas/' . $imgName;
        }

        // Modelos (usamos instancias locales para no pisar $this->model)
        $adminModel = new AdminModel();
        $idAdmin    = (int)$_SESSION['user']['id'];

        // Insertar respuesta
        $respId = $adminModel->responderPreguntaQnA($preguntaId, $idAdmin, $html, $imgPath);

        if ($respId > 0) {
            // marcar como leída y respondida
            $adminModel->marcarLeidoPregunta($preguntaId, 1);
            $adminModel->cambiarEstadoPregunta($preguntaId, 'respondida');

            // Obtener datos de la pregunta para notificar al alumno
            $hilo   = $adminModel->obtenerHiloQnA($preguntaId);
            $preg   = $hilo['pregunta'] ?? null;

            if ($preg) {
                $alumnoId  = (int)$preg['usuario_id'];
                $cursoId   = (int)$preg['curso_id'];
                $leccionId = (int)$preg['leccion_id'];
                $tituloLeccion = $preg['leccion_titulo'] ?? 'Lección';

                // Datos del alumno
                $userModel = new UserModel();
                $alumno    = $userModel->getById($alumnoId);

                // Notificación interna
                $notifModel = new NotificacionesModel();
                $linkAlumno = BASE_URL . "Cursos/leccion/{$cursoId}/{$leccionId}";
                $notifModel->crear(
                    $alumnoId,
                    "Tienes una respuesta del profesor",
                    "Lección: {$tituloLeccion}",
                    $linkAlumno
                );

                // Email al alumno
                $toEmail = $alumno['email'] ?? null;
                $toName  = $alumno['nombre'] ?? ($alumno['nombre_usuario'] ?? 'Alumno');
                if ($toEmail) {
                    $htmlMail = "<h3>Tu pregunta ha sido respondida</h3>
                             <p>Lección: <b>" . htmlspecialchars($tituloLeccion) . "</b></p>
                             <p><b>Respuesta:</b></p>{$html}";
                    // Requiere send_mail() definido en Helpers/Helpers.php
                    send_mail($toEmail, $toName, "Respuesta del profesor - Orion3D", $htmlMail);
                }
            }

            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'id' => $respId, 'img' => $imgPath]);
            return;
        }

        echo json_encode(['success' => false, 'msg' => 'No se pudo guardar la respuesta']);
    }


    public function setEstadoQna()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user'])) {
            http_response_code(401);
            exit;
        }
        if (!csrf_verify($_POST['csrf'] ?? '')) {
            http_response_code(419);
            echo json_encode(['success' => false]);
            return;
        }
        $id = (int)($_POST['id'] ?? 0);
        $estado = $_POST['estado'] ?? '';
        $this->loadModel('AdminModel');
        $ok = $this->model->cambiarEstadoPregunta($id, $estado);
        echo json_encode(['success' => $ok]);
    }

    public function setLeidoQna()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user'])) {
            http_response_code(401);
            exit;
        }
        if (!csrf_verify($_POST['csrf'] ?? '')) {
            http_response_code(419);
            echo json_encode(['success' => false]);
            return;
        }
        $id = (int)($_POST['id'] ?? 0);
        $leido = (int)($_POST['leido'] ?? 1);
        $this->loadModel('AdminModel');
        $ok = $this->model->marcarLeidoPregunta($id, $leido);
        echo json_encode(['success' => $ok]);
    }
    public function notificaciones()
    {
        
        // Solo admins
        if (empty($_SESSION['user']) || ($_SESSION['user']['rol'] ?? '') !== 'admin') {
            http_response_code(401);
            header('Content-Type: application/json; charset=utf-8');
            echo json_encode(['success' => false, 'msg' => 'auth']);
            exit;
        }

        // Evita cualquier salida previa (BOM/warnings)
        while (ob_get_level()) {
            ob_end_clean();
        }
        ini_set('display_errors', '0'); // no mezclar warnings con JSON
        header('Content-Type: application/json; charset=utf-8');

        $this->loadModel('AdminModel');
        try {
            $items = $this->model->ultimasQnaPendientes(10);
            $count = $this->model->contarQnaPendientes();
            echo json_encode(['success' => true, 'count' => (int)$count, 'items' => $items], JSON_UNESCAPED_UNICODE);
        } catch (Throwable $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'msg' => 'server']);
        }
        exit; // 👈 importantísimo
    }
}
