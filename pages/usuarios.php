<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>

    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="../css/sty.css">

</head>

<body>

    <?php require_once('../container/Navar.php') ?>

    <?php
    require_once('../config/db.php');

    $porPagina = 5;
    $paginaActual = isset($_GET['pagina']) ? (int)$_GET['pagina'] : 1;
    $inicio = ($paginaActual - 1) * $porPagina;

    $sql = $conexion->query("SELECT * FROM usuarios LIMIT $inicio, $porPagina");

    $totalRegistros = $conexion->query("SELECT COUNT(*) FROM usuarios")->fetch_row()[0];
    $totalPaginas = ceil($totalRegistros / $porPagina);


    ?>
    <div class="w-full flex justify-center">
        <table class="w-full md:w-3/5 lg:w-4xl text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 bg-white shadow-md rounded-lg overflow-hidden m-4">
            <thead class="text-xs text-gray-700 uppercase bg-blue-500 text-white">
                <tr>
                    <th scope="col" class="px-6 py-3">
                        <i class="fas fa-id-card"></i> ID
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <i class="fas fa-user"></i> Nombre
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <i class="fas fa-fingerprint"></i> Huella Digital
                    </th>
                    <th scope="col" class="px-6 py-3">
                        <i class="fas fa-cog"></i> Action
                    </th>
                </tr>
            </thead>
            <tbody class="bg-white">
                <?php
                if ($sql) {
                    while ($datos = $sql->fetch_object()) {
                ?>
                        <tr class="hover:bg-gray-100">
                            <th scope="row" class="px-6 py-3 border-t"><?= $datos->idUsuario ?></th>
                            <td class="px-6 py-3 border-t"><?= $datos->nombre ?></td>
                            <td class="px-6 py-3 border-t"><?= $datos->huella_digital ?></td>
                            <td class="px-6 py-3 border-t">
                                <button class="btn-editar bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded data-id-usuario="<?= $datos->idUsuario?>">
                                    <i class="fas fa-edit"></i> Editar
                                </button>
                                <button class="eliminar-usuario bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded mr-2" data-id="<?= $datos->idUsuario ?>">
                                    <i class="fas fa-trash"></i> Eliminar
                                </button>
                                <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                                    <i class="fas fa-eye"></i> Ver
                                </button>
                            </td>
                        </tr>
                <?php
                    }
                } else {
                    echo "<tr><td colspan='4' class='text-center'>No se encontraron datos.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <div class="flex justify-center mt-4">
        <?php for ($i = 1; $i <= $totalPaginas; $i++) : ?>
            <a href="?pagina=<?= $i ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded mx-2 <?= $paginaActual == $i ? 'opacity-50 cursor-not-allowed' : '' ?>">
                <?= $i ?>
            </a>
        <?php endfor;  ?>
    </div>

    <!--Modal Editar-->
    <div id="editarUsuarioModal" class="fixed z-10 inset-0 overflow-y-auto hidden" aria-labelledby="modal-title" role="dialog" aria-modal="true">
  <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
    <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
    <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
      <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
        <div class="sm:flex sm:items-start">
          <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
              Editar Usuario
            </h3>
            <div class="mt-2">
              <form action="../ruta/a/tu/archivo.php" method="post">
                <input type="hidden" id="idUsuario" name="idUsuario">
                <div class="mt-3">
                  <label for="nombre" class="block text-sm font-medium text-gray-700">Nombre</label>
                  <input type="text" id="nombre" name="nombre" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <!-- Aquí puedes agregar más campos según sea necesario -->
                <div class="mt-3">
                  <label for="huella_digital" class="block text-sm font-medium text-gray-700">Huella Digital</label>
                  <input type="text" id="huella_digital" name="huella_digital" class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                </div>
                <div class="mt-3">
                  <button type="button" id="guardarEdicion" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Guardar
                  </button>
                  <button type="button" id="cancelarEdicion" class="mt-2 inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancelar
                  </button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
        <button type="button" id="cerrarModal" class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
          Cerrar
        </button>
      </div>
    </div>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<script>
    // Evento de clic en el botón "Editar"
$(".btn-editar").on("click", function() {
    const idUsuario = $(this).data("id-usuario"); 
    const nombre = $(this).closest("tr").find("td:nth-child(2)").text(); 
    const huellaDigital = $(this).closest("tr").find("td:nth-child(3)").text(); // Huella digital del usuario

    // Llena el formulario de edición con los datos del usuario seleccionado
    $("#idUsuario").val(idUsuario);
    $("#nombre").val(nombre);
    $("#huella_digital").val(huellaDigital);

    $("#editarUsuarioModal").show(); 
});

// Botón "Guardar"
$("#guardarEdicion").on("click", function() {
    const idUsuario = $("#idUsuario").val();
    const nombre = $("#nombre").val();
    const huellaDigital = $("#huella_digital").val(); 

    $.ajax({
        type: 'POST',
        url: '../controllers/user/actualizar_usuario.php', 
        data: {
            id: idUsuario,
            nombre: nombre,
            huella_digital: huellaDigital
        },
        success: function(data) {

            $("#editarUsuarioModal").hide();

            Swal.fire({
                title: 'Éxito',
                text: 'Usuario actualizado con éxito',
                icon: 'success',
            }).then(function() {
                // Recarga la página
                location.reload();
            });
        },
        error: function() {

            Swal.fire({
                title: 'Error',
                text: 'Hubo un error al actualizar el usuario.',
                icon: 'error',
            });
        }
    });
});

// Botón "Cancelar"
$("#cancelarEdicion").on("click", function() {
    // Oculta el formulario de edición
    $("#editarUsuarioModal").hide();
});

</script>

</script>

    <script src="../JS/eliminar_usuario.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>