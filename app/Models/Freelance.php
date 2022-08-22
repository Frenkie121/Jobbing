<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Freelance extends Model
{
    use HasFactory;

    protected $fillable = ['profession', 'location', 'description', 'salary'];

    public function user()
    {
        return $this->morphOne(User::class, 'userable');
    }

    public function links()
    {
        return $this->hasMany(Link::class);
    }

    public function experiences()
    {
        return $this->hasMany(Experience::class);
    }
}
