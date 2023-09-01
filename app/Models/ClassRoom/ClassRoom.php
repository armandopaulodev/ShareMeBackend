<?php

namespace App\Models\ClassRoom;

use App\Models\Subject\Subject;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function subjects(){

        return $this->hasMany(Subject::class);
    }
}
