<section class="">
  <div class="px-0 py-20 mx-auto max-w-7xl sm:px-4">
    <div class="w-full px-4 pt-5 pb-6 mx-auto mt-8 mb-6 bg-white rounded-none shadow-xl sm:rounded-lg sm:w-10/12 md:w-8/12 lg:w-6/12 xl:w-4/12 sm:px-6">
      <h1 class="mb-4 text-lg font-semibold text-left text-gray-900">Ingreso de usuarios</h1>
      @if($error)<div class="alert text-green-800 bg-green-100 my-2" role="alert">{{ $error }}</div>@endif
      <form class="mb-8 space-y-4" wire:submit.prevent="login">
        <label class="block">
          <span class="block mb-1 text-xs font-medium text-gray-700">Correo</span>
          <input class="form-input" type="text" wire:model.defer="email" placeholder="Ex. jondoe@scanntech.com" inputmode="email" />
          @error('email')<span class="text-green-700 text-sm mt-1">{{ $message }}</span>@enderror 
        </label>
        <label class="block">
          <span class="block mb-1 text-xs font-medium text-gray-700">Contraseña</span>
          <input class="form-input" type="password" wire:model.defer="password" placeholder="••••••••" />
          @error('password')<span class="text-green-700 text-sm mt-1">{{ $message }}</span>@enderror
        </label>
        <input type="submit" class="w-full py-3 mt-1 btn btn-primary" value="Iniciar Sesión" />
      </form>
    </div>
  </div>
</section>
