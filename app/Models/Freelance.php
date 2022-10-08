<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Freelance extends Model
{
    use HasFactory;

    protected $fillable = ['profession', 'location', 'description', 'salary'];

    // ACCESSORS
    public function getAppliedAtAttribute()
    {
        return date_format(Carbon::make($this->pivot->created_at), 'F d, Y');
    }

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