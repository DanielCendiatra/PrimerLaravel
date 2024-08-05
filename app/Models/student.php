<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class student extends Model
{
    protected $primarykey = 'id_student';

    use HasFactory;
    protected $fillable = ['user_id', 'course'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function student_tasks() { 
        return $this->hasMany(Student_task::class); 
    }
}
