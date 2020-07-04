<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use \Dimsav\Translatable\Translatable;

    public $translatedAttributes = ['name','description'];
    protected $guarded=[];
    protected $appends=['image_path','profit_percent'];

    public function category(){
        return $this->belongsTo(Category::class);
    }
    public function getImagePathAttribute(){
        return asset('uploads/product_images/'.$this->image);
    }
    public function  getProfitPercentAttribute(){
        $profit=$this->sale_price - $this->purchase_price;
        $profit_percent=$profit * 100 / $this->purchase_price;
        return number_format($profit_percent,2);
    }
    public function orders(){
        return $this->belongsToMany(Order::class,'order_product');
    }
}
