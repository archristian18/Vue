<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderList extends Model
{
    use HasFactory;

    /** @var array */
    protected $fillable = [
        'quantity',
        'total_price',
        'customer_id',
        'menu_id',
    ];

    /**
     * Retrieves the Customer Orders of the Order List
     *
     * @return App\Models\CustomerOrder[]
     */
    public function customer_orders()
    {
        return $this->belongsTo(CustomerOrder::class, 'customer_id');
    }

    /**
     * Retrieves the Menu of the Order List
     *
     * @return App\Models\Menu[]
     */
    public function menus()
    {
        return $this->belongsTo(Menu::class, 'menu_id');
    }
}
