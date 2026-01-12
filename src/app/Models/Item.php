<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'image_path',
        'is_sold',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
