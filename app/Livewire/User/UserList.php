<?php

namespace App\Livewire\User;

use Livewire\Component;
use Livewire\Attributes\On; 
use App\Models\User;

class UserList extends Component
{
    public $users = [];
    
    protected $listeners = ['showCreateModal' => 'openModal'];
    
    public function mount()
    {
        $this->loadUserList();
    }

    #[On('user-saved')] 
    public function handleUserSaved()
    {
        $this->loadUserList();
    }

    #[On('user-updated')] 
    public function handleUserUpdated()
    {
        $this->loadUserList();
    }

    public function loadUserList()
    {

        $this->users = User::allUsers();
        
        
    }
    public function render()
    {
        return view('livewire.user.user-list');
    }
}
