<?php

namespace App\Models;

use App\Traits\HasTranslations;
use App\Traits\SearchFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    use HasTranslations, SearchFilter;

    protected $guarded = ['id'];

    public $translatable = ['name','description'];


    public function getImageAttribute($value)
    {
        return url("")."/".$value;
    }

    public function getPdfFileAttribute($value)
    {
        return url("")."/".$value;
    }

    
    public function samples()
    {
        return $this->hasMany(Sample::class);
    }

    public function sliders()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

}
