<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class course extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = ['name_course'];

    protected $primaryKey = 'id_course';

    public function users(){
        return $this->belongsToMany(User::class);
    }

    public function tasks(){
        return $this->hasMany(Task::class);
    }

    protected $table = 'courses';
}
