<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductTranslation extends Model
{
    protected $fillable =['name','description','short_description'];

    public $timestamps = false;
}
