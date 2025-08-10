<?php
class PostModel extends Mysql
{
    public function __construct()
    {
        parent::__construct();
    }

    // Contar publicaciones activas
    public function contarPublicaciones()
    {
        $sql = "SELECT COUNT(*) as total FROM posts WHERE publicado = 1";
        $result = $this->select_one($sql);
        return $result['total'];
    }
    public function obtenerPublicaciones()
    {
        $sql = "SELECT id, titulo, creado_at, publicado FROM posts ORDER BY creado_at DESC";
        return $this->select($sql);
    }

    public function eliminarPublicacion($id)
    {
        $sql = "DELETE FROM posts WHERE id = ?";
        return $this->delete($sql, [$id]);
    }

    public function cambiarEstado($id, $estado)
    {
        $sql = "UPDATE posts SET publicado = ? WHERE id = ?";
        return $this->update($sql, [$estado, $id]);
    }
}
