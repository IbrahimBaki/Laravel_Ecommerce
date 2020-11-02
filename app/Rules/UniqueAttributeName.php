<?php

namespace App\Rules;

use App\Models\AttributeTranslation;
use Illuminate\Contracts\Validation\Rule;

class UniqueAttributeName implements Rule
{

    private $attribute_name;
    private $attribute_id;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($attr_name,$attr_id)
    {
        $this->attribute_name = $attr_name;
        $this->attribute_id = $attr_id;

    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if($this->attribute_id)
            $attribute = AttributeTranslation::where('name',$value)->where('attribute_id','!=',$this->attribute_id)->first();
        else
            $attribute = AttributeTranslation::where('name',$value)->first();


       if($attribute){
           return false;
       }else{
           return true;
       }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'This Name already Exists before';
    }
}
