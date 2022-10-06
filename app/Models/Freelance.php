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

    public function jobs()
    {
        return $this->belongsToMany(Job::class)
                ->withPivot(['is_hired', 'created_at'])
                ->withTimestamps();
    }

    // 
    public function hasAppliedToJob(int $job_id)
    {
        return $this->jobs->contains($job_id);
    }

    public function hasBeenHired(int $job_id)
    {
        return $this->jobs->filter(fn($item) => $item->pivot->job_id == $job_id && $item->pivot->is_hired == 1);
    }
}