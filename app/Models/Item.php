<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'store_name',
        'quantity',
        'user_id',
        'hurry_flag',
        'complete_flag',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
