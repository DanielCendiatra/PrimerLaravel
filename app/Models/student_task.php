<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class student_task extends Model
{
    use HasFactory, SoftDeletes;

    protected $primaryKey = 'id_student_task';

    protected $fillable = ['task_id', 'student_id', 'estado', 'archivo', 'note'];

    public function task() { 
        return $this->belongsTo(Task::class); 
    } 

    public function student() { 
        return $this->belongsTo(Student::class); 
    }

}





    
    
