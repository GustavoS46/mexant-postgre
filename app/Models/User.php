<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $fillable = ['name', 'email', 'senha']; // Adicionei os campos 'cpf' e 'senha'

    public $timestamps = false; // Desabilita o uso dos campos created_at e updated_at
}
