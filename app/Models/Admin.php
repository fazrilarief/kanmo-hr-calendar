<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Model;

class Admin extends Model
{
    use HasFactory;

    protected $fillable = ['nip', 'name', 'password'];

    protected $primaryKey = 'id';

    public function getAuthPassword()
    {
        return $this->password;
    }
}
