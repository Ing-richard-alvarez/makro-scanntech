<div class="p-6">
    <!--Ventana Modales -->
    <livewire:user.edit-user />
    <livewire:user.delete-user />

    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Listado De Usuarios</h2>
        <livewire:user.create-user />
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full table-fixed">
            <thead class="bg-gray-50">
                <tr>
                    <th width="20%" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Nombre</th>
                    <th width="20%" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Correo</th>
                    <th width="20%" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                    <th width="20%" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Administrador</th>
                    <th width="20%" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @if($users && count($users)>0)
                    @foreach($users as $user)
                        <tr class="hover:bg-gray-50" >
                            <td class="px-6 py-4">{{$user['name']}}</td>
                            <td class="px-6 py-4">{{$user['email']}}</td>
                            <td class="px-6 py-4">{{$user['active'] == true ? 'Activo' : 'Inactivo'}}</td>
                            <td class="px-6 py-4">{{$user['isAdmin'] == true ? 'Si' : 'No'}}</td>
                            <td class="px-6 py-4">
                                <button wire:click="$dispatch('showModal', { userId: {{ $user['id'] }} })" 
                                    class="text-blue-600 hover:text-blue-900 mr-3 transition-colors duration-200 flex items-center">
                                    <i class="fas fa-edit"></i>
                                    <span class="ml-1">Editar</span>
                                </button>
                                <button wire:click="$dispatch('showModalDeleteUser', { userId: {{ $user['id'] }} })" 
                                    class="text-gray-600 hover:text-gray-900 transition-colors duration-200 flex items-center mt-1">
                                    <i class="fas fa-power-off {{ $user['active'] === true ? 'text-green-600' : 'text-red-600' }}"></i>
                                    <span class="ml-1">{{ $user['active'] === true ? 'Desactivar' : 'Activar' }}</span>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>