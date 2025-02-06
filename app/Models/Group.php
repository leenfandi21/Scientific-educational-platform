<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'group_participants', 'group_id', 'user_id');
    }

    public function messages()
    {
        return $this->hasMany('App\Models\Message', 'group_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
