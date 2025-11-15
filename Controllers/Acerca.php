<?php
class Acerca extends Controller
{
    public function __construct()
    {
        parent::__construct();
        session_start();
    }

    public function index()
    {
        $data['perfil'] = 'no';
        $data['title'] = 'Acerca de Albarikoque';
        $data['categorias'] = $this->model->getCategorias();
        $this->views->getView('acerca', 'index', $data);
    }
}
