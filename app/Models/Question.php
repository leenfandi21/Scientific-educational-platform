<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Grammer;
use App\Models\Answer;
use App\Models\Choice;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
        'question_text',
        'grammer_id',
        'exam_id'
    
    ];

    public function answers(){
        return $this->hasMany(Answer::class,'question_id');
    }

    public function choices(){
        return $this->hasMany(Choice::class,'question_id');
    }

    public  function user(){
        return $this->belongsTo(User::class);
    }

    public  function grammer(){
        return $this->belongsTo(Grammer::class);
    }
    /**
     * Get the exam that owns the Question
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }
}
