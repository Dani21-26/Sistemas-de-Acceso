<?php

$resultados_por_pagina = 8;
$pagina_actual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
if ($pagina_actual < 1) {
    $pagina_actual = 1;
}
$offset = ($pagina_actual - 1) * $resultados_por_pagina;

// Verificar si se ha enviado una fecha o nombre para filtrar
$fecha_filtro = isset($_GET['fecha']) ? $_GET['fecha'] : '';
$nombre_filtro = isset($_GET['nombre']) ? $_GET['nombre'] : '';

$sql_base = "SELECT acceso_de_user.id, acceso_de_user.fecha_hora, acceso_de_user.tipo_acceso, usuarios.nombre 
             FROM acceso_de_user 
             JOIN usuarios ON acceso_de_user.idUsuario = usuarios.idUsuario";

// Añadir filtros si se han enviado fecha o nombre
if (!empty($fecha_filtro) || !empty($nombre_filtro)) {
    $sql_base .= " WHERE";
    if (!empty($fecha_filtro)) {
        $sql_base .= " DATE(acceso_de_user.fecha_hora) = '$fecha_filtro'";
    }
    if (!empty($fecha_filtro) && !empty($nombre_filtro)) {
        $sql_base .= " AND";
    }
    if (!empty($nombre_filtro)) {
        $sql_base .= " usuarios.nombre LIKE '%$nombre_filtro%'";
    }
}

$total_resultados_sql = "SELECT COUNT(*) AS total FROM ($sql_base) AS subquery";
$total_resultados_result = $conexion->query($total_resultados_sql);
$total_resultados = $total_resultados_result->fetch_assoc()['total'];

$total_paginas = ceil($total_resultados / $resultados_por_pagina);

$sql = $sql_base . " LIMIT $resultados_por_pagina OFFSET $offset";
$resultado = $conexion->query($sql);
