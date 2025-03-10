<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'customer_id'=>['required','integer','exists:customer,id'],
            'amount'=>['required','numeric'],
            'status'=>['required','string'],
            'billed_date'=>['required', 'date', 'date_format:Y-m-d H:i:s'],
            'paid_date'=>['date', 'date_format:Y-m-d H:i:s'],
        ];
    }
}
