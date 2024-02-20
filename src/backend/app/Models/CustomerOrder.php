<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerOrder extends Model
{
    use HasFactory;

    /** @var bool */
    public $timestamps = true;

    /** @var array */
    protected $fillable = [
        'name',
        'status',
    ];

    /**
     * Retrieve all Order List under this Customer
     *
     * @return App\Models\OrderList
     */
    public function order_lists()
    {
        return $this->hasMany(OrderList::class, 'customer_id');
    }
}
