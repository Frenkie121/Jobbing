<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Job extends Model
{
    use HasFactory;

    protected $fillable = ['customer_id', 'sub_category_id', 'title', 'slug', 'type', 'location', 'image', 'description', 'salary', 'deadline', 'duration', 'company_name', 'company_url', 'company_description'];

    const TYPES = [
        1 => 'FULL-TIME',
        2 => 'PART-TIME',
        3 => 'INTERNSHIP',
        4 => 'FREELANCE',
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

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

    public function getImageAttribute($value)
    {
        return asset('storage/jobs/' . $value);
    }

    public function getTypeClassAttribute()
    {
        return strtolower(self::TYPES[$this->attributes['type']]);
    }

    public function getDurationAttribute($value)
    {
        return $value . ' ' . Str::plural('week', $value);
    }

    public function getDeadlineAttribute($value)
    {
        return date_format(Carbon::make($value), 'F d, Y');
    }

    public function getCreatedAtAttribute($value)
    {
        return date_format(Carbon::make($value), 'F d, Y');
    }

    // MUTATORS
    /**
     * Generate slug attribute from title
     *
     * @param mixed $value
     * 
     * @return void
     * 
     */
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value);
    }

    // RELATIONSHIPS

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
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

    public function requirements()
    {
        return $this->hasMany(Requirement::class);
    }

    // SCOPES
    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }
}
