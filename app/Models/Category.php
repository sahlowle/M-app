<?php

namespace App\Models;

use App\Traits\HasTranslations;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    use HasTranslations;

    const MALL_TYPE = 'mall';
    const SERVICE_TYPE = 'service';
    const RESTAURANT_TYPE = 'restaurant';

    public $translatable = ['name'];

    protected $guarded = ['id'];
    
}
