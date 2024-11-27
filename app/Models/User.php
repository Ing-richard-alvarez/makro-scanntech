<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    public $id;
    public $email;
    public $password;
    public $name;
    public $isAdmin;
    public $active;

    public function __construct(array $attributes = [])
    {
        foreach ($attributes as $key => $value) {
            $this->{$key} = $value;
        }
    }
    
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'isAdmin',
        'active'
    ];

    protected $hidden = [
        'password',
    ];

    protected function casts(): array
    {
        parent::__construct($attributes);
        foreach ($attributes as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public function toArray()
    {
        return [
            'id' => $this->id,
            'email' => $this->email,
            'password' => $this->password,
            'name' => $this->name,
            'isAdmin' => $this->isAdmin,
            'active' => $this->active,
        ];
    }

    public static function allUsers()
    {
        $filePath = storage_path('app/users.json');
        
        if (!file_exists($filePath)) {
            return [];
        }
    
        $json = file_get_contents($filePath);

        $users = json_decode($json, true);
        
        return $users;
    }

    public static function saveUser($users)
    {
        $filePath = storage_path('app/users.json');
        file_put_contents($filePath, json_encode($users, JSON_PRETTY_PRINT));
    }

}
