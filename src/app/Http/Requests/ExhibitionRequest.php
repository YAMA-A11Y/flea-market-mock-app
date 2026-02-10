<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'image' => ['required', 'image', 'mimes:jpeg,png'],
            'categories' => ['required', 'array'],
            'categories.*' => ['required', 'string'],
            'condition' => ['required', 'string'],
            'name' => ['required', 'string'],
            'brand' => ['nullable', 'string'],
            'description' => ['required', 'string', 'max:255'],
            'price' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages()
    {
        return [
            'image.required' => '商品画像を選択してください。',
            'image.image' => '画像ファイルを選択してください。',
            'image.mimes' => '画像はjpegまたはpng形式でアップロードしてください。',

            'categories.required' => 'カテゴリーを選択してください。',
            'categories.array' => 'カテゴリーの選択が不正です。',
            'categories.*.required' => 'カテゴリーを選択してください。',

            'condition.required' => '商品の状態を選択してください。',

            'name.required' => '商品名を入力してください。',

            'description.required' => '商品の説明を入力してください。',
            'description.max' => '商品の説明は255文字以内で入力してください。',

            'price.required' => '販売価格を入力してください。',
            'price.numeric' => '販売価格は数値で入力してください。',
            'price.min' => '販売価格は0円以上で入力してください。',
        ];
    }
}