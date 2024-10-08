<?php

namespace App\Models;

use App\Traits\HasTranslations;
use App\Traits\SearchFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;

    use HasTranslations, SearchFilter;

    public $translatable = ['name','description','mall_name'];

    protected $guarded = ['id'];

    public function getImageAttribute($value)
    {
        return url("")."/".$value;
    }

   
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function sliders()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

}
