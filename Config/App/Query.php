<?php
class Query extends Conexion{
    private $pdo, $con, $sql, $datos;
    private $tieneConexion;
    private $conexionReportada = false;
    public function __construct() {
        $this->pdo = new Conexion();
        $this->con = $this->pdo->conect();
        $this->tieneConexion = $this->con instanceof PDO;
    }
    private function sinConexion()
    {
        if ($this->tieneConexion) {
            return false;
        }
        if (!$this->conexionReportada) {
            error_log('No hay conexión disponible para ejecutar la consulta.');
            $this->conexionReportada = true;
        }
        return true;
    }
    public function select(string $sql)
    {
        if ($this->sinConexion()) {
            return array();
        }
        $this->sql = $sql;
        $resul = $this->con->prepare($this->sql);
        $resul->execute();
        $data = $resul->fetch(PDO::FETCH_ASSOC);
        return $data;
    }
    public function selectAll(string $sql)
    {
        if ($this->sinConexion()) {
            return array();
        }
        $this->sql = $sql;
        $resul = $this->con->prepare($this->sql);
        $resul->execute();
        $data = $resul->fetchAll(PDO::FETCH_ASSOC);
        return $data;
    }
    public function save(string $sql, array $datos)
    {
        if ($this->sinConexion()) {
            return 0;
        }
        $this->sql = $sql;
        $this->datos = $datos;
        $insert = $this->con->prepare($this->sql);
        $data = $insert->execute($this->datos);
        if ($data) {
            $res = 1;
        }else{
            $res = 0;
        }
        return $res;
    }
    public function insertar(string $sql, array $datos)
    {
        if ($this->sinConexion()) {
            return 0;
        }
        $this->sql = $sql;
        $this->datos = $datos;
        $insert = $this->con->prepare($this->sql);
        $data = $insert->execute($this->datos);
        if ($data) {
            $res = $this->con->lastInsertId();
        } else {
            $res = 0;
        }
        return $res;
    }
}
?>