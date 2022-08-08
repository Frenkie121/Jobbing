<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    const TYPES = [
        1 => 'FULL-TIME',
        2 => 'PART-TIME',
        3 => 'INTERNSHIP',
        4 => 'FREELANCE',
    ];

    // ACCESSORS
    public function getSalaryAttribute($value)
    {
        return number_format($value) . ' XAF';
    }

    public function getTypeAttribute($value)
    {
        return self::TYPES[$value];
    }

    public function getDescriptionAttribute($value)
    {
        return substr($value, 0, 250) . '...';
    }

    public function getTypeClassAttribute()
    {
        return strtolower(self::TYPES[$this->attributes['type']]);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function freelances()
    {
        return $this->belongsToMany(Freelance::class);
    }

    public function statuses()
    {
        return $this->belongsToMany(Status::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }
}
