<div class="min-h-screen bg-gray-100">
    <!-- Sidebar -->
    <div class="fixed inset-y-0 left-0 z-30 w-64 transform bg-gray-900 transition duration-300 ease-in-out" 
         x-data="{ open: true }"
         :class="{ '-translate-x-full': !open, 'translate-x-0': open }">
        
        <!-- Logo -->
        <div class="flex h-16 items-center justify-between bg-gray-800 px-4">
            <div class="flex items-center">
                <img src="{{ asset('images/logo.png') }}" class="h-8 w-8" alt="Logo">
                <span class="ml-2 text-white">Scanntech</span>
            </div>
            <button @click="open = !open" class="text-gray-300 hover:text-white">
                <i class="fas fa-arrow-left"></i>
            </button>
        </div>

        <!-- Menu Items -->
        <nav class="mt-5 px-2">
            <a href="{{ route('stores.index') }}" class="group flex items-center px-2 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('stores.index') ? 'bg-gray-700' : '' }}">
                <i class="fas fa-store mr-3"></i>
                Tiendas
            </a>
            <a href="{{ route('urls.index') }}" class="group flex items-center px-2 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white {{ request()->routeIs('urls.index') ? 'bg-gray-700' : '' }}">
                <i class="fas fa-link mr-3"></i>
                URLs
            </a>
            <button wire:click="logout" class="group flex w-full items-center px-2 py-2 text-base font-medium text-gray-300 hover:bg-gray-700 hover:text-white">
                <i class="fas fa-sign-out-alt mr-3"></i>
                Cerrar Sesión
            </button>
        </nav>
    </div>

    <!-- Main Content -->
    <div class="flex flex-col pl-64">
        <!-- Top bar -->
        <header class="flex h-16 items-center justify-between bg-white px-6 shadow">
            <button class="text-gray-500 hover:text-gray-600" @click="open = !open">
                <i class="fas fa-bars"></i>
            </button>
            <div class="text-gray-500">
                {{ auth()->user()->email ?? '' }}
            </div>
        </header>

        <!-- Page Content -->
        <main class="flex-1 p-6">
            {{ $slot }}
        </main>
    </div>
</div>