<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'amount',
        'before_amount'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
