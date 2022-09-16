<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quarry extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'company_id',
        'category_id',
        'city_id',
        'large',
        'permission',
        'address',
        'latitude',
        'longitude',
        'url'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function images()
    {
        return $this->hasMany(QuarryImage::class, 'quarry_id');
    }
}
