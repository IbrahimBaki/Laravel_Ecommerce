<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Option extends Model
{
    use Translatable;
    protected $with = ['translations'];
    protected $translatedAttributes = ['name'];

    protected $fillable = ['attribute_id','product_id','price'];

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id','id');

    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class,'attribute_id');
    }


}
