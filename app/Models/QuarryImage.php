<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuarryImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'quarry_id',
        'image'
    ];

    public function quarry()
    {
        return $this->belongsTo(Quarry::class, 'quarry_id');
    }
}
