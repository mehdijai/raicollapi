<?php

namespace App\Http\Requests\Playlists;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class UpdatePlaylistRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->role->privileges->contains('slug', 'upload-media') && $this->playlist->creator_id === $this->user()->id;
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
            'cover' => [
                'nullable',
                File::types(["image/*"])
                    ->max(12 * 1024),
            ]
        ];
    }
}
