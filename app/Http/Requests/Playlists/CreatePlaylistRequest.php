<?php

namespace App\Http\Requests\Playlists;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class CreatePlaylistRequest extends FormRequest
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
            "public" => ["required", "boolean"],
            "description" => ["nullable", "string", "max:500"],
            "name" => ["required", "string", "max:200"],
            "collaborators" => ["nullable", "array"],
            "trackId" => ["nullable", "exists:tracks,id", "string"],
            'cover' => [
                'nullable',
                File::types(["image/*"])
                    ->max(12 * 1024),
            ]
        ];
    }
}
