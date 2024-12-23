<?php

namespace App\Http\Requests\Quiz;

use Illuminate\Foundation\Http\FormRequest;

class SubmitAnswerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
        // return session()->has('quiz_state');
    }

    public function rules(): array
    {
        return [
            'quiz_id' => 'required|exists:quizzes,id',
            'answer_id' => [
                'required',
                'exists:quiz_options,id',
                function ($attribute, $value, $fail) {
                    // 選択された回答が、このクイズに属しているか確認
                    $quizOption = \App\Models\Quiz\QuizOption::where('id', $value)
                        ->where('quiz_id', $this->quiz_id)
                        ->exists();
                    
                    if (!$quizOption) {
                        $fail('選択された回答は、このクイズに属していません。');
                    }
                }
            ]
        ];
    }

    // バリデーションエラーメッセージ
    public function messages(): array
    {
        return [
            'quiz_id.required' => 'クイズIDが指定されていません。',
            'quiz_id.exists' => '指定されたクイズは存在しません。',
            'answer_id.required' => '回答が選択されていません。',
            'answer_id.exists' => '選択された回答は存在しません。'
        ];
    }

}