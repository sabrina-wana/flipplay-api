<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMediaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isPatch  = $this->isMethod('PATCH');
        $presence = $isPatch ? 'sometimes' : 'required';

        $uniqueTitle = Rule::unique('media', 'title');
        if ($isPatch) {
            // boleh tetap memakai judul miliknya sendiri saat update
            $uniqueTitle->ignore($this->route('media'));
        }

        return [
            'type'       => [$presence, Rule::in(['anime', 'drama', 'manga', 'light_novel'])],
            'title'      => [$presence, 'string', 'max:255', $uniqueTitle],
            'genres'     => [$presence, 'array', 'min:1'],
            'genres.*'   => ['string', 'max:50'],
            'year'       => [$presence, 'integer', 'min:1900', 'max:' . (date('Y') + 1)],
            'score'      => [$presence, 'numeric', 'between:0,10'],
            'unit_count' => [$presence, 'integer', 'min:1'],
            'country'    => [
                Rule::requiredIf(!$isPatch && $this->input('type') === 'drama'),
                'nullable', 'string', 'max:100',
            ],
            'author'     => [
                Rule::requiredIf(!$isPatch && in_array($this->input('type'), ['manga', 'light_novel'], true)),
                'nullable', 'string', 'max:100',
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required'   => 'Judul media wajib diisi',
            'title.unique'     => 'Judul media sudah terdaftar',
            'type.in'          => 'Jenis media harus anime, drama, manga, atau light_novel',
            'score.between'    => 'Score harus antara 0 dan 10',
            'country.required' => 'Negara wajib diisi untuk drama',
            'author.required'  => 'Author wajib diisi untuk manga dan light novel',
        ];
    }
}
