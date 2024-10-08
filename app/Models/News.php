<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;
use App\Traits\SearchFilter;

class News extends Model
{
    use HasFactory;

    use HasTranslations, SearchFilter;

    protected $guarded = ['id'];

    public $translatable = ['title','content'];

    protected $table = "news";

    public function getImageAttribute($value)
    {
        return url("")."/".$value;
    }
}
