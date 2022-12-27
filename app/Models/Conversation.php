<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id', 
        'receiver_id',
    ];

    // public function getLastSenderAttribute()
    // {
    //     return $this->sender()->where('id', $this->messages->last()?->sender_id)->first()?->name;
    // }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function job()
    {
        return $this->hasOne(Job::class);
    }
}
