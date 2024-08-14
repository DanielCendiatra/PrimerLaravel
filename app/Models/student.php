<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class student extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $primarykey = 'id_student';
 
    protected $fillable = ['user_id', 'course'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function student_tasks() { 
        return $this->hasMany(Student_task::class); 
    }
}
