<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required','string','max:255','unique:products,name,'.$this->id],
            'code' => ['required','string','regex:/^P\d{5}$/','unique:products,code,'.$this->id],
            'min_quan' => ['required','numeric','min:1'],
            'price' => ['required','numeric','min:1'],
            'activated' => ['required','boolean'],
            'group_id' => ['required','numeric','exists:groups,id'],
        ];
    }

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            "code.regex"=>'يجب أن يبدأ الرمز بالحرف P وبعده 5 أرقام',
        ];
    }
}
