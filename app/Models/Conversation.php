<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    public function chats()
    {
        return $this->hasMany(Chat::class);
    }

    public function latestChat()
    {
        return $this->hasOne(Chat::class)->latestOfMany();
    }
    
}
