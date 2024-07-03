<!-- modal_editar_usuario.php -->

<div id="modalEditarUsuario" class="modal hidden fixed w-full h-full top-0 left-0 flex items-center justify-center">
    <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>

    <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">

        <div class="modal-content py-4 text-left px-6">
            <!-- Close modal button -->
            <div class="flex justify-end items-center">
                <span class="modal-close cursor-pointer z-50">
                    <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                        <path d="M1 1l16 16m0-16L1 17" />
                    </svg>
                </span>
            </div>

            <!-- Modal content -->
            <h2 class="text-2xl font-semibold mb-4">Editar Usuario</h2>
            <form id="formEditarUsuario">
                <input type="hidden" id="editIdUsuario" name="editIdUsuario">
                <div class="mb-4">
                    <label for="editNombre" class="block text-sm font-medium text-gray-700">Nombre:</label>
                    <input type="text" id="editNombre" name="editNombre" class="form-input mt-1 block w-full" required>
                </div>
                <input type="hidden" id="editHuella" name="editHuella">
                <div class="mb-4">
                    <label for="editCedula" class="block text-sm font-medium text-gray-700">Cédula:</label>
                    <input type="text" id="editCedula" name="editCedula" class="form-input mt-1 block w-full" required>
                </div>
                <div class="mb-4">
                    <label for="editCelular" class="block text-sm font-medium text-gray-700">Celular:</label>
                    <input type="text" id="editCelular" name="editCelular" class="form-input mt-1 block w-full" required>
                </div>

                <div class="text-right">
                    <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Guardar Cambios</button>
                </div>
            </form>
        </div>
    </div>
</div>