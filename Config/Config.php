<?php
// URL base para enlaces en HTML
define("BASE_URL", "http://localhost/Orion3D/");

// Ruta física en disco para acceder a archivos
define("BASE_PATH", __DIR__ . "/../");
// Zona horaria
date_default_timezone_set('Europe/Madrid');
// Configuración de la base de datos
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'orion3d');
define('DB_CHARSET', 'utf8');
//Datos envio de correo
const SMTP_HOST = "smtp.gmail.com";
const NOMBRE_REMITENTE = "Orion3D";
const EMAIL_REMITENTE = "goizuetajoseluis@gmail.com";
const WEB_EMPESA = "WebLupi.com";
const EMAIL_EMPRESA = "jose luis Goizueta";
const PASSWORD_EMAIL = "pevt lopw oswh zuzp";
// IDs de cursos (ajusta según tu BD)
define('CID_UNITY_3D',            1);
define('CID_UNITY_2D',            2);
define('CID_CSHARP',              3);

define('CID_WEB_HTMLCSS',         4);
define('CID_WEB_JS',              5);
define('CID_WEB_PHP',             6);

define('CID_BLENDER_MODELADO',    7);
define('CID_BLENDER_TEXTURIZADO', 8);
define('CID_BLENDER_ANIMACION',   9);

