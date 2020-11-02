<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use Translatable;
    protected $with=['translations'];
    public $translatedAttributes=['name'];

    protected $guarded=[];


    public function options()
    {
        return $this->hasMany(Option::class,'attribute_id','id');
    }

}
