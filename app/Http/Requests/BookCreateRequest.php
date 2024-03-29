<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookCreateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'bookName' => 'required|min:3|max:8',
            'price' => 'required|max:10',
            'textArea' => 'max:300',
            'bookAvatar' => 'required|mimes:png,jpg|max:7000',
            'bookFile' => 'required|mimes:pdf|max:10000',
        ];
    }

//        protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
//    {
//        dd($validator->errors(), $this->all());
//        parent::failedValidation($validator); // TODO: Change the autogenerated stub
//    }
}
