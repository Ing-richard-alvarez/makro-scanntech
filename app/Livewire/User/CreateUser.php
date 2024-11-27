<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Collection;
use App\Models\User;

class CreateUser extends Component
{

    public $id;
    public $name;
    public $email;
    public $isAdmin = false;
    public $active = true;
    public $password;
    public $password_confirmation;

    public $error = '';

    public $openModal = false;

    public function showModal()
    {
        $this->openModal = true;
    }

    public function hideModal()
    {
        $this->openModal = false;
    }
    
    public function createUser()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
        ], [
            'name.required' => 'Por favor ingrese su usuario',
            'email.required' => 'Por favor ingrese su correo',
            'email.email' => 'Debes proporcionar una dirección de correo electrónico válida.',
            'password.required' => 'Por favor ingrese su contraseña',
            'password_confirmation.required' => 'Por favor, confirme su contraseña'
        ]);

        $this->users = User::allUsers();
        $userCollection = collect($this->users);
        $userFound = $userCollection->firstWhere('name', $this->name);

        if ($userFound) {
            $this->error = 'Existe un registro con el mismo usuario';
            return;
        }

        $newUser = [
            'id' => count($this->users) + 1,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'name' => $this->name,
            'isAdmin' => $this->isAdmin,
            'active' => $this->active,
        ];

        $this->users[] = $newUser;
        User::saveUser($this->users);
        $this->dispatch('user-saved'); 
        $this->reset(); // Limpiar todo el formulario
        session()->flash('success', 'Formulario enviado y limpiado correctamente.');
        
    }

    public function render()
    {
        return view('livewire.user.create-user');
    }
}
