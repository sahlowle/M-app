<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    use HasTranslations;

    public $translatable = ['name'];

    protected $guarded = ['id'];

    public function getImageAttribute($value)
    {
        return url("")."/".$value;
    }
    
}
