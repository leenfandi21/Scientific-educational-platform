<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Question;
use App\Models\level;

class Grammer extends Model
{
    use HasFactory;

    protected $fillable = [
        'text',
        'level_id'
    ];

    public function questions()
    {
       return $this->hasMany(Question::class);
    }

    public function course(){
        return $this ->belongsTo(Course::class);
    }

}
