<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['name'];
    protected $guarded=[];

    public function products(){
        return $this->hasMany(Product::class);
    }
}
