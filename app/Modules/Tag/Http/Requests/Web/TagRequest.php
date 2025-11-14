<?php

namespace App\Modules\Tag\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'unique:tags']
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => ':attribute is required',
            'name.unique:tags' => 'every :attribute must be unique'
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'tag title'
        ];
    }
}
