<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class Museum extends Model
{
    use HasFactory;

    use HasTranslations;

    public $translatable = ['name','description'];

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
