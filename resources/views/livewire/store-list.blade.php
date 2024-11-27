<div class="p-6">
    <livewire:create-store />
    <livewire:edit-store />

    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Listado de Tiendas</h2>
        <button 
            wire:click="$dispatch('showCreateModal')" 
            class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-md flex items-center transition-colors duration-200">
            <i class="fas fa-plus mr-2"></i>
            Agregar
        </button>
    </div>

    {{-- Mensaje de éxito --}}
    @if (session()->has('message'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4 flex justify-between items-center transition-all duration-300">
            <span>{{ session('message') }}</span>
            <button wire:click="$set('showMessage', false)" class="text-green-700 hover:text-green-900 transition-colors duration-200">
                <i class="fas fa-times"></i>
            </button>
        </div>
    @endif

    {{-- Tabla de tiendas --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nombre</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Ubicación</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Estado</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @if(count($stores) > 0)
                    @foreach($stores as $store)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap">{{ $store['id'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $store['name'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">{{ $store['location'] }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $store['status'] === 'Activo' 
                                        ? 'bg-green-100 text-green-800' 
                                        : 'bg-red-100 text-red-800' }}">
                                    {{ $store['status'] }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <button wire:click="$dispatch('showEditModal', { storeId: {{ $store['id'] }} })" 
                                    class="text-blue-600 hover:text-blue-900 mr-3 transition-colors duration-200 flex items-center">
                                    <i class="fas fa-edit"></i>
                                    <span class="ml-1">Editar</span>
                                </button>
                                <button wire:click="confirmToggleStatus({{ $store['id'] }})"
                                        class="text-gray-600 hover:text-gray-900 transition-colors duration-200 flex items-center mt-1">
                                    <i class="fas fa-power-off {{ $store['status'] === 'Activo' ? 'text-green-600' : 'text-red-600' }}"></i>
                                    <span class="ml-1">{{ $store['status'] === 'Activo' ? 'Desactivar' : 'Activar' }}</span>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                            No hay tiendas registradas
                        </td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    {{-- Modal de confirmación para cambiar estado --}}
    @if($showDeleteModal)
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center">
        <div class="relative bg-white rounded-lg shadow-xl max-w-md mx-auto p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-2">
                Cambiar Estado de Tienda
            </h3>
            <p class="text-gray-500 mb-4">
                ¿Está seguro que desea {{ $storeToToggle['status'] === 'Activo' ? 'desactivar' : 'activar' }} 
                la tienda "{{ $storeToToggle['name'] }}"?
            </p>
            <div class="mt-5 sm:mt-6 flex justify-end space-x-3">
                <button wire:click="toggleStatus"
                        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded transition-colors duration-200">
                    Confirmar
                </button>
                <button wire:click="$set('showDeleteModal', false)"
                        class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded transition-colors duration-200">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
    @endif
</div>