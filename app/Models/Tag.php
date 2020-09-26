<?php

namespace App\Models;

use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use Translatable;

    protected $with =['translations'];
    protected $translatedAttributes = ['name'];

    protected $fillable = ['slug'];

}
