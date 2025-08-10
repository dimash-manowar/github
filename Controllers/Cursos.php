<?php
class Cursos extends Controller
{
    public function __construct()
    {
        parent::__construct();
        if (empty($_SESSION['user'])) {
            header('Location: ' . BASE_URL . 'Auth');
            exit;
        }
        $this->loadModel('CursosModel'); // usamos este modelo para progreso/lecciones
    }

    public function index()
    {
        $this->loadModel('CursosModel');

        $cat  = isset($_GET['cat'])  ? trim($_GET['cat'])  : null;
        $lvl  = isset($_GET['lvl'])  ? trim($_GET['lvl'])  : null;
        $q    = isset($_GET['q'])    ? trim($_GET['q'])    : null;
        $sort = $_GET['sort'] ?? 'recientes';
        $page = max(1, (int)($_GET['page'] ?? 1));
        $per  = (int)($_GET['per'] ?? 9);
        if (!in_array($per, [6, 9, 12, 18], true)) $per = 9;

        $res = $this->model->listarPublicadosPaged($cat ?: null, $lvl ?: null, $q ?: null, $sort, $page, $per);

        $data = [
            'page_title'   => 'Catálogo de cursos - Orion3D',
            'cursos'       => $res['items'],
            'total'        => $res['total'],
            'page'         => $res['page'],
            'per'          => $res['perPage'],
            'total_pages'  => max(1, (int)ceil(($res['total'] ?: 0) / $res['perPage'])),
            'categorias'   => $this->model->categorias(),
            'niveles'      => $this->model->niveles(),
            'filtro_cat'   => $cat,
            'filtro_lvl'   => $lvl,
            'busqueda'     => $q,
            'sort'         => $sort,
            'page_functions_js' => 'catalogoCursos.js'
        ];
        $this->view('Cursos/index', $data);
    }
    // Listado de lecciones del curso
    public function ver($cursoId)
    {
        if (empty($_SESSION['user'])) {
            header('Location: ' . BASE_URL . 'Auth');
            exit;
        }

        $uid = (int)$_SESSION['user']['id'];
        $this->loadModel('CursosModel');

        $curso      = $this->model->getCursoById((int)$cursoId);
        $lecciones  = $this->model->listarLeccionesConEstado((int)$cursoId, $uid);
        $progreso   = $this->model->resumenProgresoCurso((int)$cursoId, $uid);

        $data = [
            'page_title'        => ($curso['titulo'] ?? 'Curso') . ' - Índice',
            'curso_id'          => (int)$cursoId,
            'lecciones'         => $lecciones,
            'progreso'          => $progreso,
            'page_functions_js' => 'cursoVer.js', // 👈 JS de switches
        ];
        $this->view('Cursos/ver', $data);
    }



    // Marcar/desmarcar lección como completada (AJAX)
    public function toggleLeccion()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            exit;
        }
        if (empty($_SESSION['user'])) {
            http_response_code(401);
            exit;
        }
        if (!csrf_verify($_POST['csrf'] ?? '')) {
            http_response_code(419);
            echo json_encode(['success' => false, 'message' => 'CSRF']);
            return;
        }

        $userId    = (int)$_SESSION['user']['id'];
        $leccionId = (int)($_POST['leccion_id'] ?? 0);
        $estado    = (int)($_POST['estado'] ?? 0);

        if ($leccionId <= 0 || ($estado !== 0 && $estado !== 1)) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'Parámetros inválidos']);
            return;
        }
        // antes de setLeccionEstado():
        $prev = $this->model->getLeccionEstado($userId, $leccionId);
        $ok = $this->model->setLeccionEstado($userId, $leccionId, $estado);
        // si pasó de NO→SÍ, sumamos 10 min; si SÍ→NO, restamos 10 min (opcional)
        if ($ok) {
            if ($prev === 0 && $estado === 1) {
                $this->model->addStudyMinutes($userId, 10);
            }
            if ($prev === 1 && $estado === 0) {
                $this->model->subStudyMinutes($userId, 10);
            }
        }

        $cursoId = $this->model->getCursoIdByLeccion($leccionId);
        $curso   = $cursoId ? $this->model->getProgresoCurso($userId, $cursoId) : ['tot' => 0, 'comp' => 0, 'pct' => 0];
        $resumen = $this->model->getResumenProgreso($userId);
        $badges  = $this->model->getBadges($userId); // pendientes/favoritos

        header('Content-Type: application/json');
        echo json_encode([
            'success' => (bool)$ok,
            'curso'   => $curso,
            'resumen' => $resumen,
            'badges'  => $badges
        ]);
        exit;
    }

    public function preguntar()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_SESSION['user'])) {
            http_response_code(401);
            exit;
        }
        header('Content-Type: application/json');
        if (empty($_SESSION['user'])) {
            echo json_encode(['success' => false, 'msg' => 'auth']);
            return;
        }

        $uid       = (int)$_SESSION['user']['id'];
        $cursoId   = (int)($_POST['curso_id'] ?? 0);
        $leccionId = (int)($_POST['leccion_id'] ?? 0);
        $html      = trim($_POST['contenido_html'] ?? '');
        if (!csrf_verify($_POST['csrf'] ?? '')) {
            http_response_code(419);
            echo json_encode(['success' => false, 'msg' => 'CSRF']);
            return;
        }

        $userId    = (int)$_SESSION['user']['id'];
        $cursoId   = (int)($_POST['curso_id'] ?? 0);
        $leccionId = (int)($_POST['leccion_id'] ?? 0);
        $html      = trim($_POST['contenido_html'] ?? '');

        if ($cursoId <= 0 || $leccionId <= 0 || $html === '') {
            echo json_encode(['success' => false, 'msg' => 'bad']);
            return;
        }

        // Sanitizar: whitelist básica
        $html = strip_tags($html, '<p><b><strong><i><em><u><ul><ol><li><br><a><code><pre><img>');
        // quitar on* y scripts
        $html = preg_replace('/on\w+="[^"]*"/i', '', $html);
        $html = preg_replace('/<script\b[^>]*>(.*?)<\/script>/is', '', $html);

        // Guardar imagen si viene
        $imgPath = null;
        if (!empty($_FILES['imagen']['name']) && $_FILES['imagen']['error'] === 0) {
            $ext = strtolower(pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION));
            $ok  = in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif']);
            $ok &= ($_FILES['imagen']['size'] <= 2 * 1024 * 1024); // 2MB
            if ($ok) {
                $dir = 'Assets/imagen/qna/';
                if (!is_dir($dir)) @mkdir($dir, 0777, true);
                $fname = 'q_' . date('Ymd_His') . '_' . bin2hex(random_bytes(3)) . '.' . $ext;
                $dest = $dir . $fname;
                if (move_uploaded_file($_FILES['imagen']['tmp_name'], $dest)) {
                    $imgPath = $dest; // ruta relativa para el front (lo prefiere así tu JS)
                }
            }
        }

        $this->loadModel('CursosModel');
        $id = $this->model->insertPregunta($userId, $cursoId, $leccionId, $html, $imgPath);
        if ($id > 0) {
            // Notificaciones a admins + email
            $this->loadModel('UserModel');
            $admins = $this->model->getAdmins();

            // obtener autor (usuario) para el email
            $autor = $_SESSION['user'] ?? [];
            $autorNombre = $autor['nombre'] ?? $autor['nombre_usuario'] ?? 'Alumno';

            // preparar modelos
            $this->loadModel('NotificacionesModel');
            $notifModel = $this->model; // ojo: $this->model cambia, mejor instanciar directo:
            require_once BASE_PATH . "Models/NotificacionesModel.php";
            $notifModel = new NotificacionesModel();

            $link = BASE_URL . "Admin/preguntas?focus=" . $id;
            foreach ($admins as $a) {
                // Notificación interna
                $notifModel->crear((int)$a['id'], "Nueva pregunta de $autorNombre", "Revisa y responde la nueva duda.", $link);

                // Email
                $html = "<h3>Nueva pregunta</h3>
                 <p><b>Alumno:</b> {$autorNombre}</p>
                 <p><b>Curso/Lección:</b> #{$cursoId} / #{$leccionId}</p>
                 <p><b>Contenido:</b></p>{$html}";
                send_mail($a['email'], $a['nombre'] ?? $a['nombre_usuario'] ?? 'Admin', "Nueva pregunta en Orion3D", $html);
            }

            if ($id <= 0) {
                echo json_encode(['success' => false, 'msg' => 'db']);
                return;
            }

            echo json_encode([
                'success' => true,
                'item' => [
                    'id'             => $id,
                    'contenido_html' => $safeHtml,
                    'imagen'         => $imgPath
                ]
            ]);
            exit;
        }
    }
    public function leccion($cursoId, $leccionId)
    {
        if (empty($_SESSION['user'])) {
            header('Location: ' . BASE_URL . 'Auth');
            exit;
        }
        $uid = (int)$_SESSION['user']['id'];
        $cursoId   = (int)$cursoId;
        $leccionId = (int)$leccionId;

        $curso   = $this->model->getCursoById($cursoId);
        $leccion = $this->model->getLeccionDeCurso($cursoId, $leccionId);
        if (!$curso || !$leccion) {
            $_SESSION['alert'] = ['icon' => 'error', 'title' => 'No encontrada', 'text' => 'Esa lección no existe en este curso.'];
            header('Location: ' . BASE_URL . 'Cursos/ver/' . $cursoId);
            exit;
        }

        $lecciones = $this->model->listarLeccionesConEstado($cursoId, $uid);
        $prog      = $this->model->resumenProgresoCurso($cursoId, $uid);
        $preguntas = $this->model->getPreguntasLeccion($leccionId);
        $data = [
            'page_title'  => $curso['titulo'] . ' - ' . $leccion['titulo'],
            'curso_id'    => $cursoId,
            'leccion_id'  => $leccionId,
            'info'        => $leccion,
            'preguntas' => $preguntas,
            'lecciones'   => $lecciones,
            'progreso'    => $prog,
            'completada'  => (int)($this->findInList($lecciones, $leccionId)['completada'] ?? 0),
            'page_functions_js' => 'cursoLeccion.js'
        ];
        $this->view('Cursos/leccion', $data);
    }

    // helper opcional dentro del controlador
    private function findInList(array $arr, int $id): ?array
    {
        foreach ($arr as $x) if ((int)$x['id'] === $id) return $x;
        return null;
    }
}
