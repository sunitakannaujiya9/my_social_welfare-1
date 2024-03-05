<?php

namespace App\Http\Requests\Admin\Masters;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHayatiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'h_id' => 'nullable',
            'user_id' => 'nullable',
            'house_no' => 'required',
            'area' => 'required',
            'landmark' => 'required',
            'pincode' => 'required',
            'city' => 'required',
            'state' => 'required',
            'contact' => 'max:10|required',
            'alternate_contact_no' => 'max:10|nullable',
            'bank_name' => 'required',
            'account_no' => 'required',
            'ifsc_code' => 'required',
            'signature' => 'nullable',
            'status' => 'nullable',
            'sign_uploaded_live_certificate' => 'nullable',
            'download_pdf'=>'nullable',
            'pdfPath'=> 'nullable',

        ];
    }
}