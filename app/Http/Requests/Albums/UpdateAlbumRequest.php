<?php

namespace App\Http\Requests\Albums;

use App\Enums\AlbumType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\File;

class UpdateAlbumRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()->role->privileges->contains('slug', 'upload-media') && $this->album->creator_id === $this->user()->id;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "artist_id" => ["required", "exists:artists,id", "uuid", "string"],
            "name" => ["required", "string", "max:200"],
            "type" => ["required", "string", [new Enum(AlbumType::class)],],
            "year" => ["required", "numeric"],
            'cover' => [
                'nullable',
                File::types(["image/*"])
                    ->max(12 * 1024),
            ]
        ];
    }
}
