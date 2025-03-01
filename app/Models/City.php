<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
class City extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'tourist_attractions'];

    protected $casts = [
        'tourist_attractions' => 'array'
    ];

    public function routesFrom(): HasMany
    {
        return $this->hasMany(Route::class, 'from_city_id');
    }

    public function routesTo(): HasMany
    {
        return $this->hasMany(Route::class, 'to_city_id');
    }
}
