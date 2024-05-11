<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    protected $guarded = ['id',];

    protected $hidden = [
        'created_at',
        'updated_at',
        'imageable_id',
        'imageable_type',
    ];

    public function imageable()
    {
        return $this->morphTo();
    }

    public function getImageAttribute($value)
    {
        return url("")."/".$value;
    }
}
