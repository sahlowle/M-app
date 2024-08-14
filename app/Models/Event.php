<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;
use App\Traits\SearchFilter;

class Event extends Model
{
    use HasFactory;

    use HasTranslations, SearchFilter;

    public $translatable = ['name','description'];

    protected $guarded = ['id'];

    public function getImageAttribute($value)
    {
        return url("")."/".$value;
    }
}
