<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MainCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $type = $this->request->get('type');
        if($type === 'main_category'){
            return [

                'name'=>'required',
                'slug'=>'required|unique:categories,slug,'. $this->id,
            ];
        }else {
            return [
                'parent_id' => 'required|exists:categories,id',
                'name' => 'required',
                'slug' => 'required|unique:categories,slug,' . $this->id,
            ];
        }
    }
}
