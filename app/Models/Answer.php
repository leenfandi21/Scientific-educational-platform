<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Question;

class Answer extends Model
{
    use HasFactory;
    protected $fillable = [
        'answer_text',
        'status',
        'question_id',
       // 'user_id'
    ];

    public  function question(){
        return $this->belongsTo(Question::class);
    }
}
