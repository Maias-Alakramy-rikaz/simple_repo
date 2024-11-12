<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ImporterRequest extends FormRequest
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
            'first_name' => ['required','string','max:255',Rule::unique('exporters')->where('first_name',$this->first_name)->where('last_name',$this->last_name)->ignore($this->id)], 
            'last_name' => ['required','string','max:255',Rule::unique('exporters')->where('first_name',$this->first_name)->where('last_name',$this->last_name)->ignore($this->id)],
            'phone_number'=> ['required','string','regex:/^\+?[1-9]\d{1,14}$/','unique:Exporters,phone_number,'.$this->id],
            'email' => ['required','email','unique:Exporters,email,'.$this->id],
            'blocked' => ['required','boolean'],
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
            "first_name.unique" => "هذا المورد (اسم وكنية) موجود مسبقا",
            "last_name.unique" => "هذا المورد (اسم وكنية) موجود مسبقا",
            'phone_number.regex' => 'الرجاء إدخال الرقم بالترميز العالمي E165'
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
            //
        ];
    }
}
