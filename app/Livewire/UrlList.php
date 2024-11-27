<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Url;

class UrlList extends Component
{
    public $urls = [];
    public $editingId = null;
    public $editingUrl;

    public function mount()
    {
        $this->refreshUrls();
    }

    public function refreshUrls()
    {
        $urls = Url::all();
        
        // Creamos un array base con las 3 posiciones
        $baseUrls = collect([1, 2, 3])->map(function($order) {
            return [
                'url' => '',
                'order' => $order
            ];
        });

        // Si hay URLs guardadas, las mezclamos con el array base
        if ($urls->isNotEmpty()) {
            $urls->each(function($url) use (&$baseUrls) {
                $baseUrls = $baseUrls->map(function($baseUrl) use ($url) {
                    if ($baseUrl['order'] === $url->order) {
                        return [
                            'url' => $url->url,
                            'order' => $url->order
                        ];
                    }
                    return $baseUrl;
                });
            });
        }

        $this->urls = $baseUrls->toArray();
    }

    public function startEditing($order)
    {
        $this->editingId = $order;
        $currentUrl = collect($this->urls)->firstWhere('order', $order);
        $this->editingUrl = $currentUrl['url'] ?? '';
    }

    public function cancelEditing()
    {
        $this->reset(['editingId', 'editingUrl']);
    }

    public function save()
    {
        try {
            $this->validate([
                'editingUrl' => 'required|url',
            ], [
                'editingUrl.required' => 'La URL es obligatoria',
                'editingUrl.url' => 'Debe ser una URL válida'
            ]);

            // Obtener todas las URLs existentes como colección
            $existingUrls = collect($this->urls);
            
            // Verificar si la URL ya existe en otro orden
            $duplicateUrl = $existingUrls->first(function($url) {
                return $url['url'] === $this->editingUrl && $url['order'] !== $this->editingId;
            });

            if ($duplicateUrl) {
                $this->addError('editingUrl', 'Esta URL ya existe en el orden ' . $duplicateUrl['order']);
                $this->dispatch('notify', message: 'Esta URL ya existe en otro registro', type: 'error');
                return;
            }

            // Actualizar o agregar la URL editada
            $updatedUrls = $existingUrls->map(function($url) {
                if ($url['order'] === $this->editingId) {
                    return [
                        'url' => $this->editingUrl,
                        'order' => $this->editingId
                    ];
                }
                return $url;
            });

            // Convertir a objetos URL y guardar solo las URLs no vacías
            $urlObjects = $updatedUrls->filter(function($url) {
                return !empty($url['url']);
            })->map(function ($url) {
                return new Url($url['url'], $url['order']);
            });

            Url::save($urlObjects);
            
            $this->refreshUrls();
            $this->reset(['editingId', 'editingUrl']);
            $this->dispatch('notify', message: 'URL actualizada exitosamente', type: 'success');

        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'Error al actualizar la URL: ' . $e->getMessage(), type: 'error');
        }
    }

    public function render()
    {
        return view('livewire.url-list');
    }
}