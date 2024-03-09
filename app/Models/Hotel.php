<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $guarded = ['id',];
    
    public function options()
    {
     return $this->hasMany('App\Models\Option');
    }
    
    public function rates()
    {
     return $this->hasMany('App\Models\Rate');
    }
    
}
