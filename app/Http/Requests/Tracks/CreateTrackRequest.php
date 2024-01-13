<?php

namespace App\Http\Requests\Tracks;

use App\Models\Track;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File as RulesFile;

class CreateTrackRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;
    // protected $model = Track::class;
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
            "album_id" => ["required", "string", "exists:albums,id"],
            "year" => ["numeric", "required"],
            "trackNb" => ["required", "numeric"],
            "genres" => ["string", "required", "max:100"],
            'title' => ['required', 'max:255', 'string'],
            'artists' => ['required', 'max:255', 'string', 'array'],
            'cover' => [
                'nullable',
                RulesFile::types(["image/*"])
                    ->max(12 * 1024),
            ],
            'file' => [
                'required',
                RulesFile::types(["audio/*"])
                    ->max(12 * 1024),
            ],
        ];
    }
}
