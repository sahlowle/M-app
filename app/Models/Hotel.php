<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    use HasTranslations;

    public $translatable = ['name','description'];

    protected $guarded = ['id',];

    public function getImageAttribute($value)
    {
        return url("")."/".$value;
    }
    
    public function options()
    {
        return $this->hasMany(Option::class);
    }
    
    public function sliders()
    {
        return $this->morphMany(Image::class, 'imageable');
    }
    
}
