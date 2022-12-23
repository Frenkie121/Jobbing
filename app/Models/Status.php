<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    use HasFactory;

    public function jobs()
    {
        return $this->belongsToMany(Job::class);
    }

    public function getColorAttribute()
    {
        return match($this->attributes['id']){
            1 => 'gold',
            2 => 'red',
            3 => '#53b427',
            4 => '#00dbff'
        };
    }
}
