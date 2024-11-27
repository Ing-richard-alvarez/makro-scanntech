<div class="p-6">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-semibold">Listado de URLs</h2>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="min-w-full table-fixed">
            <thead class="bg-gray-50">
                <tr>
                    <th width="60%" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">URL</th>
                    <th width="20%" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Orden</th>
                    <th width="20%" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Acciones</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @for($i = 1; $i <= 3; $i++)
                    @php
                        $currentUrl = collect($urls)->firstWhere('order', $i);
                    @endphp
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            @if($editingId === $i)
                                <form wire:submit="save">
                                    <input 
                                        type="text" 
                                        wire:model="editingUrl" 
                                        class="w-full p-2 border rounded @error('editingUrl') border-red-500 @enderror"
                                        placeholder="https://ejemplo.com"
                                    >
                                    @error('editingUrl') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    <div class="mt-2">
                                        <button 
                                            type="submit"
                                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700"
                                        >
                                            <i class="fas fa-save mr-2"></i> Guardar
                                        </button>
                                        <button 
                                            type="button"
                                            wire:click="cancelEditing"
                                            class="ml-2 inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300"
                                        >
                                            <i class="fas fa-times mr-2"></i> Cancelar
                                        </button>
                                    </div>
                                </form>
                            @else
                                <span class="text-gray-900">{{ !empty($currentUrl['url']) ? $currentUrl['url'] : 'Sin asignar' }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="text-gray-900">{{ $i }}</span>
                        </td>
                        <td class="px-6 py-4">
                            @if(!($editingId === $i))
                                <button 
                                    type="button"
                                    wire:click="startEditing({{ $i }})"
                                    class="text-blue-600 hover:text-blue-900"
                                >
                                    <i class="fas fa-edit"></i> Editar
                                </button>
                            @endif
                        </td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>
</div>