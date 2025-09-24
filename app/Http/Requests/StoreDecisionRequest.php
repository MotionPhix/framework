<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDecisionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', 'in:hiring,partnership,marketing,personal'],

            'est_revenue' => ['nullable', 'numeric', 'min:0'],
            'est_cost' => ['nullable', 'numeric', 'min:0'],

            'impact' => ['nullable', 'integer', 'min:0', 'max:10'],
            'effort' => ['nullable', 'integer', 'min:0', 'max:10'],
            'time_to_value_days' => ['nullable', 'integer', 'min:0'],
            'risk' => ['nullable', 'integer', 'min:0', 'max:10'],

            'second_order_benefits' => ['nullable', 'string'],
            'second_order_risks' => ['nullable', 'string'],
            'priority' => ['nullable', 'in:Now,Next,Later'],

            'answers' => ['nullable', 'array'],
        ];
    }

    public function messages(): array
    {
        return [
            'category.in' => 'Select a valid category: hiring, partnership, marketing, or personal.',
            'priority.in' => 'Priority must be one of: Now, Next, Later.',
        ];
    }
}
