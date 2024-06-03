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
        // 'created_at',
    ];

        /**
     * Get the user's first name.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function firstName(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => $this->created_at->diffForHumans(),
        );
    }

    // public function name(): Attribute
    // { 
    //     diffForHumans
    //     return new Attribute(
    //         get: fn ($value) => strtoupper($value),
    //         set: fn ($value) => $value,
    //     );
    // }

    
    // public function customer()
    // {
    //     return $this->belongsTo(User::class, 'foreign_key', 'other_key');
    // }
}
