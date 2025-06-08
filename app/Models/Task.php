<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $table = 'task';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'titulo',
        'descripcion',
        'prioridad',
        'estado',
        'fecha_creacion',
    ];
}