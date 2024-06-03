<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'created_at',
    ];

    

    public function getCreatedAtAttribute($value)
    {
        return $this->created_at->diffForHumans();
    }

  

    
    // public function customer()
    // {
    //     return $this->belongsTo(User::class, 'foreign_key', 'other_key');
    // }
}
