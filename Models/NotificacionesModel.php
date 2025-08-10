<?php
class NotificacionesModel extends Mysql
{
    public function __construct(){ parent::__construct(); }

    public function crear(int $usuarioId, string $titulo, string $cuerpo=null, string $link=null): int {
        return (int)$this->insert(
            "INSERT INTO notificaciones (usuario_id, titulo, cuerpo, link) VALUES (?,?,?,?)",
            [$usuarioId, $titulo, $cuerpo, $link]
        );
    }

    public function listar(int $usuarioId, int $limit=20): array {
        return $this->select(
            "SELECT id, titulo, cuerpo, link, leido, creado_at
             FROM notificaciones
             WHERE usuario_id = ?
             ORDER BY leido ASC, creado_at DESC
             LIMIT $limit", [$usuarioId]
        );
    }

    public function contarNoLeidas(int $usuarioId): int {
        $r = $this->select_one("SELECT COUNT(*) c FROM notificaciones WHERE usuario_id=? AND leido=0", [$usuarioId]);
        return (int)($r['c'] ?? 0);
    }

    public function marcarLeida(int $usuarioId, int $id): bool {
        return $this->update("UPDATE notificaciones SET leido=1 WHERE id=? AND usuario_id=?", [$id, $usuarioId]);
    }

    public function marcarTodasLeidas(int $usuarioId): bool {
        return $this->update("UPDATE notificaciones SET leido=1 WHERE usuario_id=? AND leido=0", [$usuarioId]);
    }
}
