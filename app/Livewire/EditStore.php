<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Store;
use Livewire\Attributes\On;

class EditStore extends Component
{
    public $showModal = false;
    public $showConfirmClose = false;
    public $storeId;
    public $name;
    public $location;
    public $status;
    public $hasChanges = false;

    protected $listeners = ['showEditModal' => 'openModal'];

    public function rules()
    {
        return [
            'name' => 'required|string|max:50',
            'location' => 'required|string|max:50'
        ];
    }

    protected $messages = [
        'name.required' => 'El nombre es obligatorio',
        'name.max' => 'El nombre no debe exceder 50 caracteres',
        'location.required' => 'La ubicación es obligatoria',
        'location.max' => 'La ubicación no debe exceder 50 caracteres'
    ];

    public function updated($property)
    {
        $this->hasChanges = true;
    }

    public function openModal($storeId)
    {
        try {
            $this->resetValidation();
            $this->storeId = $storeId;
            
            $stores = Store::all();
            $store = $stores->firstWhere('id', $storeId);
            
            if ($store) {
                $this->name = $store->name;
                $this->location = $store->location;
                $this->status = $store->status;
                $this->showModal = true;
                $this->hasChanges = false;
            } else {
                $this->dispatch('notify', message: 'No se encontró la tienda', type: 'error');
            }
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Error al cargar la tienda', type: 'error');
        }
    }

    public function confirmClose()
    {
        if ($this->hasChanges) {
            $this->showConfirmClose = true;
        } else {
            $this->closeModal();
        }
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->showConfirmClose = false;
        $this->reset(['name', 'location', 'storeId', 'hasChanges']);
        $this->resetValidation();
    }

    public function save()
    {
        try {
            $this->validate();

            $stores = Store::all();
            
            $existingStore = $stores->first(function($store) {
                return $store->name === $this->name && $store->id != $this->storeId;
            });

            if ($existingStore) {
                $this->addError('name', 'Ya existe una tienda con este nombre');
                $this->dispatch('notify', message: 'Ya existe una tienda con este nombre', type: 'error');
                return;
            }

            $updatedStores = $stores->map(function($store) {
                if ($store->id == $this->storeId) {
                    $store->name = $this->name;
                    $store->location = $this->location;
                }
                return $store;
            });

            Store::save($updatedStores);
            $this->closeModal();
            $this->dispatch('store-updated');
            $this->dispatch('notify', message: 'Tienda actualizada exitosamente', type: 'success');

        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Error al actualizar la tienda: ' . $e->getMessage(), type: 'error');
        }
    }

    public function render()
    {
        return view('livewire.edit-store');
    }
}