<div>
  <button class="btn btn-primary" wire:click="showModal">Agregar</button>
  @if($openModal)
  <div class="dialog dialog-sm">
    <div class="dialog-content">
      <div class="dialog-header">Crear Usuario
        <button type="button" class="btn btn-light btn-sm btn-icon" aria-label="Close" wire:click="hideModal"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg></button>
      </div>
      <div class="dialog-body">
        @if($error)<div class="alert text-red-700 bg-red-100" role="alert">{{$error}}</div>@endif
        <form class="w-full  mx-auto mb-4" wire:submit.prevent="createUser">
            <label class="block text-sm mb-1" for="name">Usuario</label>
            <input class="form-input" type="text" placeholder="Ex. jdoe" id="name" wire:model.defer="name" />
            @error('name')<span class="text-green-700 text-sm mt-1">{{ $message }}</span>@enderror

            <label class="block text-sm mb-1 mt-4" for="email">Correo</label>
            <input class="form-input" type="text" placeholder="Ex. james@bond.com" wire:model.defer="email" id="email" />
            @error('email')<span class="text-green-700 text-sm mt-1">{{ $message }}</span>@enderror

            <label class="flex items-center mt-4" for="isAdmin">
                <input type="checkbox" class="form-checkbox" wire:model.defer="isAdmin" id="isAdmin">
                <span class="ml-2 cursor-pointer">Usuario Administrador</span>
            </label>
            <label class="flex items-center mt-4" for="active">
                <input type="checkbox" class="form-checkbox" wire:model.defer="active" id="active" checked>
                <span class="ml-2 cursor-pointer">Usuario Activo</span>
            </label>
            <label class="block text-sm mb-1 mt-4" for="password">Contraseña</label>
            <input class="form-input" type="password" placeholder="••••••••" wire:model.defer="password" id="password" />
            @error('password')<span class="text-green-700 text-sm mt-1">{{ $message }}</span>@enderror

            <label class="block text-sm mb-1 mt-4" for="password_confirmation">Confirmar Contraseña</label>
            <input class="form-input" type="password" placeholder="••••••••"  wire:model.defer="password_confirmation" id="password_confirmation" />
            @error('password_confirmation')<span class="text-green-700 text-sm mt-1">{{ $message }}</span>@enderror
            
            <input type="submit" class="btn btn-primary w-full mt-4" value="Guardar"/>
            <button type="button" class="btn btn-light w-full mt-4" wire:click="hideModal">Cancelar</button>
        </form>
      </div>
    </div>
  </div>
  @endif
</div>