<?php

namespace App\Models;

use App\Traits\HasTranslations;
use App\Traits\SearchFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Benefit extends Model
{
    use HasFactory;

    use HasTranslations, SearchFilter;

    protected $guarded = ['id'];

    public $translatable = ['title','description'];


    public function getImageAttribute($value)
    {
        return url("")."/".$value;
    }
}
