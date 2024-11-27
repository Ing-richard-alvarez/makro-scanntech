<?php

namespace App\Livewire\User;

use Livewire\Component;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class EditUser extends Component
{
  
    public $error = '';
    public $id;
    public $name;
    public $email;
    public $isAdmin = false;
    public $active = false;
    public $password;

    public $users;
    public $passwordHasChanged;
    public $openModal = false;

    protected $listeners = ['showModal' => 'showModal'];

    public function showModal($userId)
    {
        $this->openModal = true;
        $this->users = User::allUsers();
        $userCollection = collect($this->users);
        $userFound = $userCollection->firstWhere('id', $userId);
        
        $this->id = $userFound['id'];
        $this->name = $userFound['name'];
        $this->email = $userFound['email'];
        $this->password = $userFound['password'];
        $this->active = $userFound['active'];
        $this->isAdmin = $userFound['isAdmin'];
    }

    public function hideModal()
    {
        $this->openModal = false;
    }

    public function updateUser()
    {
        $this->validate([
            'name' => 'required',
            'email' => 'required|email',
        ], [
            'name.required' => 'Por favor ingrese su usuario',
            'email.required' => 'Por favor ingrese su correo',
            'email.email' => 'Debes proporcionar una dirección de correo electrónico válida.'
        ]);

        $this->users = User::allUsers();
        $userCollection = collect($this->users);
        
        $existingUser = $userCollection->first(function($user) {
            return $user['email'] === $this->email && $user['id'] != $this->id;
        });

        $this->passwordHasChanged = $userCollection->first(function($user) {
            Log::info('Usuario encontrado: ' . $this->password);
            Log::info('Usuario form: ' . $user['password']);
            return $user['password'] === $this->password;
        });

        if($existingUser){
            $this->error = 'Existe un registro con el mismo usuario!';
            return;
        }

        $updatedUsers = $userCollection->map(function($user) {
            if ($user['id'] == $this->id) {
                $user['name'] = $this->name;
                $user['email'] = $this->email;
                $user['password'] = $this->passwordHasChanged? $this->password : Hash::make($this->password);
                $user['active'] = $this->active;
                $user['isAdmin'] = $this->isAdmin;
            }
            return $user;
        });

        User::saveUser($updatedUsers);
        $this->hideModal();
        $this->dispatch('user-updated');
    }


    public function render()
    {
        return view('livewire.user.edit-user');
    }
}
