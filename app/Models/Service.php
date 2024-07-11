<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Service extends Model
{
    use HasFactory;

    use HasTranslations;

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

    function scopeFilter($query,Request $request) {
        
        if ($request->filled('category_id')) {
            $query->where('category_id',$request->category_id);
        }

        if ($request->filled('name')) {
            $query->where('name->'.app()->getLocale(), 'like', '%'.$request->name.'%');
        }

    }
}
