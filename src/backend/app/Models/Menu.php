<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    /** @var array */
    protected $fillable = [
        'name',
        'price',
        'description',
        'image_path',
    ];

    public $timestamps = false;

    /**
     * Retrieve all Order List under this Menu
     *
     * @return App\Models\OrderList
     */
    public function order_lists()
    {
        return $this->hasMany(OrderList::class);
    }
}
