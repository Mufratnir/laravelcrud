<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable =[
        'name',
        'slug',
        'thumbnail',
        'category_id',
        'status',
        'description'
    ];
    public function category(){
        return $this->belongsTo(Category::class);
    }
}
