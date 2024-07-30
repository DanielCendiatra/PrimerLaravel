<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class student_task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['task_id', 'student_id', 'estado', 'archivo', 'note'];
}





    
    
