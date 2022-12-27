<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'conversation_id',
        'read',
        'content',
        'type',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function getLastTimeAttribute()
    {
        return Carbon::make($this->attributes['created_at'])->shortAbsoluteDiffForHumans();
    }

    public function getLastMessageAttribute()
    {
        return Str::limit($this->attributes['content'], '30');
    }

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
