<?php
require_once __DIR__ . '/../models/aseguradoraModel.php';

function mostrarAseguradoras()
{
    $objAseguradora = new Aseguradora();
    return $objAseguradora->consultar();
}
