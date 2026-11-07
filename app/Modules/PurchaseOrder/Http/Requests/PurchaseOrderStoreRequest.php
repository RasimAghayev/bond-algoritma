<?php

namespace App\Modules\PurchaseOrder\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PurchaseOrderStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order_date' => ['required', 'date_format:Y-m-d'],
            'number_bonds_received' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
        ];
    }
}
