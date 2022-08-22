<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $fillable = ['freelance_id', 'company', 'job_title', 'job_description', 'started_at', 'ended_at', ''];

    protected $casts = [
        'start_at' => 'date:Y-m-d',
        'end_at' => 'date:Y-m-d'
    ];

    public function freelance()
    {
        return $this->belongsTo(Freelance::class);
    }
}
