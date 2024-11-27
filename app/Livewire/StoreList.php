<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Store;
use Livewire\Attributes\On;

class StoreList extends Component
{
    public $stores = [];
    public $showDeleteModal = false;
    public $storeToToggle;

    public function mount()
    {
        $this->refreshStores();
    }

    public function refreshStores()
    {
        $this->stores = Store::all()->map(function($store) {
            return $store->toArray();
        })->toArray();
    }

    #[On('store-updated')]
    public function handleStoreUpdated()
    {
        $this->refreshStores();
    }

    #[On('store-saved')] 
    public function handleStoreSaved()
    {
        $this->refreshStores();
    }

    public function render()
    {
        return view('livewire.store-list');
    }

    public function confirmToggleStatus($id)
    {
        $this->storeToToggle = collect($this->stores)->firstWhere('id', $id);
        $this->showDeleteModal = true;
    }

    public function toggleStatus()
    {
        if ($this->storeToToggle) {
            try {
                // Guardamos el estado actual antes de cambiarlo
                $currentStatus = $this->storeToToggle['status'];
                
                $stores = collect($this->stores)->map(function ($store) use ($currentStatus) {
                    if ($store['id'] === $this->storeToToggle['id']) {
                        $store['status'] = $currentStatus === 'Activo' ? 'Inactivo' : 'Activo';
                    }
                    return $store;
                });
                
                Store::save($stores);
                $this->refreshStores();
                $this->showDeleteModal = false;
                
                $newStatus = $currentStatus === 'Activo' ? 'desactivada' : 'activada';
                $this->dispatch('notify', message: "La tienda ha sido {$newStatus} exitosamente", type: 'success');

            } catch (\Exception $e) {
                $this->dispatch('notify', message: 'Error al cambiar el estado de la tienda', type: 'error');
            }
        }
    }
}