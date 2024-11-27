<?php

namespace App\Auth;

use Illuminate\Auth\EloquentUserProvider;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class JsonUserProvider extends EloquentUserProvider
{

    protected $storagePath;

    public function __construct($hasher, $model, $storagePath = null)
    {
        parent::__construct($hasher, $model);
        $this->storagePath = $storagePath ?? storage_path('app/users.json');
    }

    /**
     * Recuperar un usuario por su identificador único.
     */
    public function retrieveById($identifier)
    {
        $users = $this->getUsersFromJson();
        $user = collect($users)->firstWhere('id', $identifier);

        return $user ? $this->getGenericUser($user) : null;
    }

    /**
     * Recuperar un usuario por sus credenciales.
     */
    public function retrieveByCredentials(array $credentials)
    {
        if (empty($credentials)) {
            return null;
        }

        $users = $this->getUsersFromJson();

        // Buscar el usuario por email
        $user = collect($users)->firstWhere('email', $credentials['email']);

        return $user ? $this->getGenericUser($user) : null;
    }

    /**
     * Validar las credenciales del usuario.
     */
    public function validateCredentials(Authenticatable $user, array $credentials)
    {
        return Hash::check($credentials['password'], $user->getAuthPassword());
    }

    /**
     * Obtener los usuarios desde el archivo JSON.
     */
    protected function getUsersFromJson()
    {
        if (!file_exists($this->storagePath)) {
            return [];
        }

        $json = file_get_contents($this->storagePath);
        return json_decode($json, true);
    }

    /**
     * Convertir un array en un usuario genérico.
     */
    protected function getGenericUser($user)
    {
        $model = $this->model;

        return new $model((array) $user);
    }

}