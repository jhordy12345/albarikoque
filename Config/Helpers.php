<?php

function verificarUsuarioActivo()
{
    if (empty($_SESSION['email'])) {
        return;
    }

    $query = new Query();
    $correo = $_SESSION['email'];
    $usuario = $query->select("SELECT estado FROM usuarios WHERE correo = '$correo' LIMIT 1");

    if (empty($usuario) || (int) $usuario['estado'] !== 1) {
        session_destroy();
        header('Location: ' . BASE_URL . 'admin');
        exit;
    }
}
