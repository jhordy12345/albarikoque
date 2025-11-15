<?php

if (!function_exists('formatFechaLima')) {
    function formatFechaLima($fecha)
    {
        if (empty($fecha)) {
            return $fecha;
        }
        try {
            $date = new \DateTime($fecha, new \DateTimeZone('America/Lima'));
        } catch (\Exception $e) {
            return $fecha;
        }
        return $date->format('d/m/Y H:i:s');
    }
}

?>
