<?php

namespace App\Livewire\Layout;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class MainLayout extends Component
{
    public $showSidebar = true;
    
    public function toggleSidebar()
    {
        $this->showSidebar = !$this->showSidebar;
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function render()
    {
        return view('livewire.layout.main-layout');
    }
}