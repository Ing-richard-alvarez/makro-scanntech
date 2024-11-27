<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>Panel de Control - Scanntech</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    @livewireStyles
</head>
<body>
    <livewire:layout.main-layout>
        {{ $slot }}
    </livewire:layout.main-layout>
    
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