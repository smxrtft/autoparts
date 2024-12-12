<?php

namespace App\Models;

use App\Models\orderProduct;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;

    protected $fillable = ['qty', 'total', 'name', 'email', 'phone', 'address', 'note'];

    public function products()
    {
        return $this->hasMany(orderProduct::class);
    }
}
