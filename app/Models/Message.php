<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'is_seen' => 'boolean',
    ];

    public function getCreatedAtAttribute($date)
    {
        $timezone = config('app.timezone');

	     return Carbon::parse($date)->setTimezone($timezone)->format('Y-m-d H:i:s');
    }
    
    public function getUpdatedAtAttribute($date)
    {
        $timezone = config('app.timezone');

	     return Carbon::parse($date)->setTimezone($timezone)->format('Y-m-d H:i:s');
    }


    
    // public function customer()
    // {
    //     return $this->belongsTo(User::class, 'foreign_key', 'other_key');
    // }
}
