<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['Titulo', 'descripción', 'tarea_date', 'estado', 'course', 'class'];

    public function classe()
    {
        return $this->belongsTo(Classe::class, 'class', 'id_class', 'name_class');
    }

    public function courses()
    {
        return $this->belongsTo(Course::class, 'course', 'id_course', 'name_course');
    }
}