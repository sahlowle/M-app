<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasTranslations;

class News extends Model
{
    use HasFactory;

    use HasTranslations;

    protected $guarded = ['id'];

    public $translatable = ['title','content'];

    protected $table = "news";
}
