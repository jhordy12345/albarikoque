-- Add the rol column to the usuarios table so application role selection works.
ALTER TABLE `usuarios`
    ADD COLUMN `rol` ENUM('Administrador','Empleado') NOT NULL DEFAULT 'Empleado' AFTER `correo`;
