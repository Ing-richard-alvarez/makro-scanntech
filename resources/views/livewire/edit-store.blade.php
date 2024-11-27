<div>
    @if($showModal)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center">
        <div class="relative bg-white rounded-lg shadow-xl max-w-md mx-auto p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Editar Tienda</h3>
            
            <form wire:submit.prevent="save">
                <!-- Campo ID (deshabilitado) -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2">
                        ID
                    </label>
                    <input type="text" 
                           value="{{ $storeId }}"
                           disabled
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-500 leading-tight bg-gray-100">
                </div>

                <!-- Campo Nombre -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="name">
                        Nombre
                    </label>
                    <input wire:model.live="name" 
                           type="text" 
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('name') border-red-500 @enderror"
                           placeholder="Nombre de la tienda">
                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Campo Ubicación -->
                <div class="mb-4">
                    <label class="block text-gray-700 text-sm font-bold mb-2" for="location">
                        Ubicación
                    </label>
                    <input wire:model.live="location" 
                           type="text" 
                           class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('location') border-red-500 @enderror"
                           placeholder="Ubicación de la tienda">
                    @error('location') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                <!-- Botones -->
                <div class="flex justify-end space-x-3">
                    <button type="submit" 
                            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">
                        Guardar
                    </button>
                    <button type="button" 
                            wire:click="confirmClose"
                            class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

    <!-- Modal de Confirmación de Cierre -->
    @if($showConfirmClose)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center">
        <div class="relative bg-white rounded-lg shadow-xl max-w-md mx-auto p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-2">
                ¿Desea cerrar sin guardar los cambios?
            </h3>
            <p class="text-gray-500 mb-4">
                Los cambios que ha realizado se perderán.
            </p>
            <div class="flex justify-end space-x-3">
                <button wire:click="closeModal"
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded">
                    Cerrar sin guardar
                </button>
                <button wire:click="$set('showConfirmClose', false)"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">
                    Continuar editando
                </button>
            </div>
        </div>
    </div>
    @endif
</div>