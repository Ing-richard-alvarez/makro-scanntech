<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Store;

class CreateStore extends Component
{
    public $showModal = false;
    public $id;
    public $name;
    public $location;
    public $hasChanges = false;
    public $showConfirmClose = false;

    protected $listeners = ['showCreateModal' => 'openModal'];

    public function mount()
    {
        $this->showModal = false;
    }

    public function updated($property)
    {
        $this->hasChanges = true;
    }

    public function openModal()
    {
        $this->resetInputs();
        $this->showModal = true;
        $this->hasChanges = false;
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
        $this->resetInputs();
    }

    private function resetInputs()
    {
        $this->id = '';
        $this->name = '';
        $this->location = '';
        $this->resetValidation();
    }

    public function save()
    {
        try {
            $this->validate([
                'id' => 'required|numeric|min:1|max:100',
                'name' => 'required|string|max:50',
                'location' => 'required|string|max:50'
            ], [
                'id.required' => 'El ID es obligatorio',
                'id.numeric' => 'El ID debe ser un número',
                'id.min' => 'El ID debe ser mayor a 0',
                'id.max' => 'El ID debe ser menor a 101',
                'name.required' => 'El nombre es obligatorio',
                'name.max' => 'El nombre no debe exceder 50 caracteres',
                'location.required' => 'La ubicación es obligatoria',
                'location.max' => 'La ubicación no debe exceder 50 caracteres'
            ]);

            $stores = Store::all();
            
            // Validación de ID duplicado
            if ($stores->where('id', $this->id)->first()) {
                $this->addError('id', 'Este ID ya está en uso');
                $this->dispatch('notify', message: 'Este ID ya está en uso', type: 'error');
                return;
            }

            // Validación de nombre duplicado
            if ($stores->where('name', $this->name)->first()) {
                $this->addError('name', 'Ya existe una tienda con este nombre');
                $this->dispatch('notify', message: 'Ya existe una tienda con este nombre', type: 'error');
                return;
            }

            $newStore = new Store(
                $this->id,
                $this->name,
                $this->location
            );

            $stores->push($newStore);
            Store::save($stores);

            $this->closeModal();
            $this->dispatch('store-saved');
            $this->dispatch('notify', message: 'Tienda creada exitosamente', type: 'success');

        } catch (\Exception $e) {
            $this->addError('general', 'Error al crear la tienda: ' . $e->getMessage());
            $this->dispatch('notify', message: 'Error al crear la tienda: ' . $e->getMessage(), type: 'error');
        }
    }
    
    public function render()
    {
        return view('livewire.create-store');
    }
}