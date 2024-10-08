<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public static function updateByKey($key,$value)  {
        return Setting::where('name',$key)->update(['value' => $value ]);
    }

}
