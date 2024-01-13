<?php

namespace App\Http\Requests\Artists;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File as RulesFile;

class CreateArtistRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->role->privileges->contains('slug', 'upload-media');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'biography' => ['required', 'max:1000', 'string'],
            'name' => ['required', 'max:255', 'string'],
            'picture' => [
                'nullable',
                RulesFile::types(["image/*"])
                    ->max(12 * 1024),
            ]
        ];
    }
}
