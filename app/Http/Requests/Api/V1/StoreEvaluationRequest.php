<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreEvaluationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'external_candidate_id' => 'required|string|max:255',
            'candidate' => 'sometimes|array',
            'candidate.firstname' => 'required_with:candidate|string|max:255',
            'candidate.lastname' => 'required_with:candidate|string|max:255',
            'candidate.email' => 'required_with:candidate|email|max:255',
            'candidate.phone' => 'nullable|string|max:50',
            'candidate.date_of_birth' => 'nullable|date',
            'candidate.gender' => 'nullable|string|max:50',
            'candidate.country' => 'nullable|string|max:100',
            'test_ids' => 'required|array|min:1',
            'test_ids.*' => 'required|integer|exists:psico_alobri_tests,id',
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validation failed.',
            'errors' => $validator->errors(),
        ], 422));
    }
}
