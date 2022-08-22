<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    use HasFactory;

    protected $fillable = ['freelance_id', 'name', 'url'];

    public function freelance()
    {
        return $this->belongsTo(Freelance::class);
    }
}
