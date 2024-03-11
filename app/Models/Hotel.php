<?php

namespace App\Models;

use Nagy\LaravelRating\Traits\Rate\Rateable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory ,Rateable;

    protected $guarded = ['id',];
    
    public function options()
    {
        return $this->hasMany(Option::class);
    }
    
    public function images()
    {
        return $this->hasMany(Image::class);
    }
    
}
