<?php

namespace App\Models\Subject;

use App\Models\Attachment\Attachment;
use App\Models\ClassRoom\ClassRoom;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    public function rooms(){
       return $this->belongsTo(ClassRoom::class);
    }

    public function attachments(){
        return $this->hasMany(Attachment::class);
    }
}
