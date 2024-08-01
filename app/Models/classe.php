<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class classe extends Model
{
    use HasFactory;
    protected $fillable = ['name_class', 'teacher_id'];

    protected $primaryKey = 'id_class';

    public function users(){
        return $this->belongsToMany(User::class , 'teacher_id');
    }

    public function tasks(){
        return $this->hasMany(Task::class);
    }

    protected $table = 'classes';
}
