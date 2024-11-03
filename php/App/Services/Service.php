<?php
namespace Joc4enRatlla\Services;

/**
 * Clase Service
 *
 * Esta clase contiene métodos útiles para el proyecto.
 */
class Service
{
    /**
     * Carga una vista.
     *
     * @param string $view La vista a cargar.
     * @param array $data Los datos a pasar a la vista.
     *
     * @return void
     */
    public static function loadView($view, $data = [])
    {
        $viewPath = str_replace('.', '/', $view);
        extract($data);

        include  $_SERVER['DOCUMENT_ROOT'] . "/../Views/$viewPath.view.php";

    }
}