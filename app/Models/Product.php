<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    use Sluggable;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'category_id',
        'status_id',
        'img',
        'price',
        'old_price',
        'hit',
        'sale'
    ];

    protected $casts = [
        'img' => 'array',
    ];
    public function sluggable() : array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
            ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function getImage()
    {
        if (!$this->img) {
            return asset('assets/front/img/no-image.png');
        } else {
            return asset("storage/{$this->img}");
        }
    }

}
