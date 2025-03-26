<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize()
    {
        return true; //logic phân quyền ở đây
    }

    public function rules()
    {
        return [
            'id_category' => 'required|exists:categories,id_category',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'old_price' => 'nullable|numeric|min:0',
            'storage' => 'required|string|max:50',
            'color' => 'required|string|max:50',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
            'image.*' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validation cho từng file
        ];
    }

    public function messages()
    {
        return [
            'id_category.required' => 'Vui lòng chọn danh mục.',
            'name.required' => 'Tên sản phẩm không được để trống.',
            'price.required' => 'Giá sản phẩm không được để trống.',
            'storage.required' => 'Dung lượng không được để trống.',
            'color.required' => 'Màu sắc không được để trống.',
            'quantity.required' => 'Số lượng không được để trống.',
            'images.*.image' => 'File phải là hình ảnh.',
            'images.*.mimes' => 'Hình ảnh phải có định dạng jpg, jpeg hoặc png.',
            'images.*.max' => 'Hình ảnh không được vượt quá 2MB.',
        ];
    }
}
