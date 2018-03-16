<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    public function categories()
{
    return $this->hasMany(Category::class);
}
}
