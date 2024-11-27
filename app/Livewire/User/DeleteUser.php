<?php

namespace App\Livewire\User;

use Livewire\Component;
use App\Models\User;
use Livewire\Attributes\On;

class DeleteUser extends Component
{
    public $openModal = false;
    public $confirmModal = false;
    public $users;
    public $id;

    protected $listeners = ['showModalDeleteUser' => 'showModal'];

    public function showModal($userId)
    {
        $this->openModal = true;
        $this->id = $userId;
    }

    public function hideModal()
    {
        $this->openModal = false;
    }

    public function confirmDeleteUser()
    {
    
        $this->users = User::allUsers();
        $userCollection = collect($this->users);
    
        $updatedUsers = $userCollection->map(function($user) {
            if ($user['id'] == $this->id) {
                
                $user['active'] = !$user['active'];
            }
            return $user;
        });

        User::saveUser($updatedUsers);
        $this->hideModal();
        $this->dispatch('user-updated');
    }

    public function render()
    {
        return view('livewire.user.delete-user');
    }
}
