<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; 
use App\Enums\TicketPriority;

class StoreTicketRequest extends FormRequest
{
   public function rules(): array
{
    return [
        'title' => ['required', 'string', 'max:255'],
        'description' => ['required', 'string'],
        'priority' => ['required', Rule::enum(TicketPriority::class)], 
        'assign_automatically' => ['required', 'boolean'],
        'responsible_id' => [
            'required_unless:assign_automatically,true', 
            'nullable', 
            'exists:responsibles,id'
        ],
    ];
}

public function messages(): array
{
    return [
        'responsible_id.required_unless' => 'Por favor, selecione um responsável técnico ou marque a opção de atribuição automática.',
    ];
}
}