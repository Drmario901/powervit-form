<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Str;

class ContactFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'string', 'email:rfc', 'max:190'],
            'phone' => ['required', 'string', 'max:40'],
            'subject' => ['nullable', 'string', 'max:180'],
            'message' => ['nullable', 'string', 'max:3000'],
            'turnstileToken' => ['required', 'string'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => $this->sanitizeText($this->input('name')),
            'email' => Str::lower(trim((string) $this->input('email'))),
            'phone' => $this->sanitizePhone($this->input('phone')),
            'subject' => $this->nullableSanitizedString($this->input('subject')),
            'message' => $this->nullableSanitizedString($this->input('message')),
            'turnstileToken' => trim((string) $this->input('turnstileToken')),
        ]);
    }

    private function sanitizeText(?string $value): string
    {
        if ($value === null) {
            return '';
        }

        return trim(strip_tags($value));
    }

    private function sanitizePhone(?string $value): string
    {
        if ($value === null) {
            return '';
        }

        return trim(strip_tags($value));
    }

    private function nullableSanitizedString(mixed $value): ?string
    {
        if ($value === null || $value === '') {
            return null;
        }

        $s = trim(strip_tags((string) $value));

        return $s === '' ? null : $s;
    }

    protected function failedValidation(Validator $validator): void
    {
        $errors = collect($validator->errors()->all())->values()->all();

        throw new HttpResponseException(response()->json([
            'success' => false,
            'status' => 422,
            'message' => 'Error de validación.',
            'errors' => $errors,
        ], 422));
    }
}
