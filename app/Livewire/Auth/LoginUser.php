<?php

namespace App\Livewire\Auth;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class LoginUser extends Component
{
    public $email = '';
    public $password = '';
    public $error = '';

    public function mount()
    {
        if(Auth::check()){
            return redirect()->route('stores.index');
        } 
    }

    public function login()
    {
        $this->validate([
            'email' => 'required|email',
            'password' => 'required'
        ], [
            'email.required' => 'Por favor ingrese su usuario',
            'email.email' => 'Debes proporcionar una dirección de correo electrónico válida.',
            'password.required' => 'Por favor ingrese su contraseña'
        ]);

        try {
            // Debug: Imprimir contenido del archivo users.json
            $users = json_decode(Storage::disk('local')->get('users.json'), true);
            Log::info('Usuarios disponibles: ' . json_encode($users));
            
            // Debug: Imprimir credenciales intentadas
            Log::info('Intento de login con email: ' . $this->email);

            if (Auth::attempt([
                'email' => $this->email,
                'password' => $this->password
            ])) {
                Log::info('Login exitoso');
                session()->flash('success', 'Inicio de sesión exitoso.');
                $this->error = '';
                return redirect()->route('stores.index');
            } else {
                // Debug: Verificar usuario encontrado
                $user = collect($users)->first(function($user) {
                    return $user['email'] === $this->email;
                });
                
                if ($user) {
                    Log::info('Usuario encontrado: ' . json_encode($user));
                } else {
                    Log::info('Usuario no encontrado');
                }

                $this->error = 'Credenciales inválidas o usuario inactivo';
                $this->password = '';
            }
        } catch (\Exception $e) {
            Log::error('Error en login: ' . $e->getMessage());
            $this->error = 'Error al procesar la solicitud. Por favor intente más tarde.';
        }
    }

    public function render()
    {
        return view('livewire.auth.login-user');
    }
}