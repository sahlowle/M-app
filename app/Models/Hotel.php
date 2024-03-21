<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Hotel extends Model
{
    use HasFactory;

    use HasTranslations;

    public $translatable = ['name','description'];

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
