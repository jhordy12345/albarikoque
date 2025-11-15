<?php
class ContactosModel extends Query
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getCategorias()
    {
        $sql = "SELECT * FROM categorias WHERE estado = 1";
        return $this->selectAll($sql);
    }
}
