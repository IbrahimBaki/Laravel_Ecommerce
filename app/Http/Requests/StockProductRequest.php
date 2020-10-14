<?php

namespace App\Http\Requests;

use App\Rules\ProductQty;
use Illuminate\Foundation\Http\FormRequest;

class StockProductRequest extends FormRequest
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
        return [
            'id'=>'required|exists:products,id',
            'sku'=>'nullable|min:4|max:11',
            'in_stock'=>'required|in:0,1',
            'manage_stock'=>'required|in:0,1',
           // 'qty'=>'required_if:manage_stock,==,1',
            'qty'=>[new ProductQty($this -> manage_stock)],



        ];
    }
}
