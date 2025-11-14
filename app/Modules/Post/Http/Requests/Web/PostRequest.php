<?php

namespace App\Modules\Post\Http\Requests\Web;

use Illuminate\Foundation\Http\FormRequest;

class PostRequest extends FormRequest
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
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'content' => ['required', 'string', 'min:10'],
            'tags' => ['nullable', 'array'],
            'tags.*' => ['exists:tags,id', 'integer'],
            'thumbnail' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif'],
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => ':attribute is required.',
            'title.min' => ':attribute must contain at least 3 characters.',
            'title.max' => ':attribute cannot exceed 255 characters.',
            'content.required' => ':attribute поста обов\'язковий.',
            'content.min' => ':attribute повинен містити щонайменше 10 символів.',
            'tags.*.exists' => 'It has no :attribute.',
            'thumbnail.image' => ':attribute must be an image.',
            'thumbnail.mimes' => ':attribute must be a file of the type: jpeg, png, jpg, gif.',
        ];
    }

    public function attributes(): array
    {
        return [
            'title' => 'Post title',
            'content' => 'Post content',
            'tags' => 'tags',
            'thumbnail' => 'Image'
        ];
    }
}
