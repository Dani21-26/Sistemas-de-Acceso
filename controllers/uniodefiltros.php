<?php

 // Verificar si se ha enviado una fecha o nombre para filtrar
 $fecha_filtro = isset($_GET['fecha']) ? $_GET['fecha'] : '';
 $nombre_filtro = isset($_GET['nombre']) ? $_GET['nombre'] : '';

 // Consulta SQL base
 $sql_base = "SELECT acceso_de_user.id, acceso_de_user.fecha_hora, acceso_de_user.tipo_acceso, usuarios.nombre 
          FROM acceso_de_user 
          JOIN usuarios ON acceso_de_user.idUsuario = usuarios.idUsuario";

 // Añadir filtros si se han enviado fecha o nombre
 if (!empty($fecha_filtro) && !empty($nombre_filtro)) {
     $sql_base .= " WHERE DATE(acceso_de_user.fecha_hora) = '$fecha_filtro' AND usuarios.nombre LIKE '%$nombre_filtro%'";
 } elseif (!empty($fecha_filtro)) {
     $sql_base .= " WHERE DATE(acceso_de_user.fecha_hora) = '$fecha_filtro'";
 } elseif (!empty($nombre_filtro)) {
     $sql_base .= " WHERE usuarios.nombre LIKE '%$nombre_filtro%'";
 }

 $total_resultados_sql = "SELECT COUNT(*) AS total FROM ($sql_base) AS subquery";
 $total_resultados_result = $conexion->query($total_resultados_sql);
 $total_resultados = $total_resultados_result->fetch_assoc()['total'];

 $total_paginas = ceil($total_resultados / $resultados_por_pagina);

 // Consulta SQL con paginación
 $sql = $sql_base . " LIMIT $resultados_por_pagina OFFSET $offset";
 $resultado = $conexion->query($sql);

?>