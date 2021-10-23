<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\HasMedia;

class Product extends Model implements HasMedia
{
    use Sluggable, SoftDeletes, InteractsWithMedia;
    
    protected $table = 'products';    

    protected $fillable = [
        'name', 'description', 'price', 'status'
    ];

    protected $attributes = [
        'status' => 1,
    ];

    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
