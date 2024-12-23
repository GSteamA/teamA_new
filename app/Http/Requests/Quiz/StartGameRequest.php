<?php

namespace App\Http\Requests\Quiz;

use Illuminate\Foundation\Http\FormRequest;

class StartGameRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'region_id' => 'required|exists:regions,id',
            'category_id' => 'required|exists:quiz_categories,id',
            'region_name' => 'required|string',
            'category_name' => 'required|string'
        ];
    }
}

