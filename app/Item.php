<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = "t_items";
    protected $fillable = [
        'id',
        'header_id',
        'item_name',
        'order_num',
        'created_at',
        'updated_at',
    ];
}
