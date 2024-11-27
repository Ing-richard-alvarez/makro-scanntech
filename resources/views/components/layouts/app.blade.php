<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>{{ $title ?? 'Scanntech' }}</title>
    
    <!-- Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    
    @livewireStyles
</head>
<body class="bg-gray-50">
    @auth
        <div class="min-h-screen" x-data="{ open: true }">
            <!-- Sidebar -->
            <div class="fixed inset-y-0 left-0 z-30 w-64 transition-transform duration-300 transform bg-white border-r border-gray-200"
                 :class="{ '-translate-x-full': !open, 'translate-x-0': open }">
                <div class="flex flex-col h-full">
                    <!-- Logo Section -->
                    <div class="flex items-center h-16 px-6 bg-gray-50">
                        <div class="flex items-center space-x-2">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-8 h-8">
                            <span class="text-xl font-semibold text-gray-800">Scanntech</span>
                        </div>
                    </div>

                    <!-- Navigation -->
                    <nav class="flex-1 px-4 space-y-1 overflow-y-auto">
                        <!-- Configuración Dropdown -->
                        <div class="py-4" x-data="{ configOpen: {{ request()->routeIs('stores.index') || request()->routeIs('urls.index') ? 'true' : 'false' }} }">
                            <button @click="configOpen = !configOpen"
                                    class="flex items-center justify-between w-full px-4 py-3 text-sm font-medium text-gray-700 transition-colors rounded-lg hover:bg-gray-100 group">
                                <div class="flex items-center">
                                    <i class="fas fa-cogs text-gray-500 group-hover:text-blue-600"></i>
                                    <span class="ml-3">Configuración</span>
                                </div>
                                <i class="fas fa-chevron-down transition-transform duration-200"
                                   :class="{ 'rotate-180': configOpen }"></i>
                            </button>
                            
                            <div x-show="configOpen" 
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 -translate-y-2"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 class="mt-2 space-y-1 px-2">

                                 <a href="{{ route('users.index') }}"
                                   class="flex items-center px-4 py-3 text-sm text-gray-600 rounded-lg transition-colors hover:bg-gray-100 {{ request()->routeIs('urls.index') ? 'bg-blue-50 text-blue-600' : '' }}">
                                    <i class="fa-solid fa-user {{ request()->routeIs('urls.index') ? 'text-blue-600' : 'text-gray-500' }}"></i>
                                    <span class="ml-3">Usuarios</span>
                                </a>
                                <a href="{{ route('stores.index') }}"
                                   class="flex items-center px-4 py-3 text-sm text-gray-600 rounded-lg transition-colors hover:bg-gray-100 {{ request()->routeIs('stores.index') ? 'bg-blue-50 text-blue-600' : '' }}">
                                    <i class="fas fa-store {{ request()->routeIs('stores.index') ? 'text-blue-600' : 'text-gray-500' }}"></i>
                                    <span class="ml-3">Tiendas</span>
                                </a>
                                
                                <a href="{{ route('urls.index') }}"
                                   class="flex items-center px-4 py-3 text-sm text-gray-600 rounded-lg transition-colors hover:bg-gray-100 {{ request()->routeIs('urls.index') ? 'bg-blue-50 text-blue-600' : '' }}">
                                    <i class="fas fa-link {{ request()->routeIs('urls.index') ? 'text-blue-600' : 'text-gray-500' }}"></i>
                                    <span class="ml-3">URLs</span>
                                </a>
                            </div>
                        </div>
                    </nav>

                    <!-- User Section & Logout -->
                    <div class="border-t border-gray-200">
                        <div class="px-4 py-4">
                            <div class="flex items-center px-4 py-3 mb-2 text-sm text-gray-700 rounded-lg bg-gray-50">
                                <i class="fas fa-user text-gray-500"></i>
                                <span class="ml-3 truncate">{{ auth()->user()->email }}</span>
                            </div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="flex items-center w-full px-4 py-3 text-sm text-red-600 rounded-lg transition-colors hover:bg-red-50 group">
                                    <i class="fas fa-sign-out-alt text-red-500"></i>
                                    <span class="ml-3">Cerrar Sesión</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="transition-all duration-300"
                 :class="{'ml-64': open, 'ml-0': !open}">
                <!-- Top bar -->
                <header class="flex items-center justify-between h-16 px-6 bg-white border-b border-gray-200">
                    <button @click="open = !open" 
                            class="p-2 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                        <i class="fas fa-bars text-gray-600"></i>
                    </button>
                </header>

                <!-- Page Content -->
                <main class="p-6">
                    {{ $slot }}
                </main>
            </div>
        </div>
    @else
        {{ $slot }}
    @endauth

    @livewireScripts
    
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <script>
        const notyf = new Notyf({
            duration: 4000,
            position: {x: 'right', y: 'top'},
            types: [
                {type: 'success', background: '#10B981', dismissible: true},
                {type: 'error', background: '#EF4444', dismissible: true}
            ]
        });

        document.addEventListener('livewire:initialized', () => {
            Livewire.on('notify', (data) => {
                notyf[data.type](data.message);
            });
        });
    </script>
</body>
</html>