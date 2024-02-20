<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;

    public $timestamps = false;

    /** @var array */
    protected $fillable = [
        'customer_id',
        'total_payment',
    ];
}
