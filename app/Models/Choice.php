<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Question;
use App\Models\User;
use App\Models\Post;
class Choice extends Model
{
    use HasFactory;

    protected $fillable = [
        'answer_text',
        'status',
        'question_id',
        'user_id',
        'image_path'
    ];

    public  function question(){
        return $this->belongsTo(Question::class);
    }

    public  function users(){
        return $this->belongsTo(User::class);
    }
}
