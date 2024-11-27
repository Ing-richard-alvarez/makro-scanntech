<?php

namespace App\Models;

use Illuminate\Support\Facades\Storage;

class Url
{
    public $url;
    public $order;

    public function __construct($url, $order)
    {
        $this->url = $url;
        $this->order = $order;
    }

    public function toArray()
    {
        return [
            'url' => $this->url,
            'order' => $this->order,
        ];
    }

    public static function all()
    {
        if (!Storage::disk('local')->exists('urls.json')) {
            return collect([]); // Retorna colección vacía si no existe el archivo
        }
        
        $json = Storage::disk('local')->get('urls.json');
        $urls = json_decode($json, true) ?? [];
        
        return collect($urls)->map(function ($url) {
            return new static(
                $url['url'],
                $url['order']
            );
        });
    }

    public static function save($urls)
    {
        $urlsArray = collect($urls)->map(function ($url) {
            if (is_array($url)) {
                return $url;
            }
            return [
                'url' => $url->url,
                'order' => $url->order,
            ];
        })->filter(function($url) {
            // Solo guardamos URLs no vacías
            return !empty($url['url']);
        })->values()->toArray();

        Storage::disk('local')->put('urls.json', json_encode($urlsArray, JSON_PRETTY_PRINT));
        return true;
    }
}