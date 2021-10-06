<?php

namespace App\Http\Requests\Products;

use Illuminate\Foundation\Http\FormRequest;

class ProductContactRequest extends FormRequest
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
        if ($this->isMethod('post')) {
            return $this->createRules();
        } elseif ($this->isMethod('put')) {
            return $this->updateRules();
        }
    }
    /**
     * Define validation rules to store method for resource creation
     *
     * @return array
     */
    public function createRules(): array
    {
        return [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required|string|max:191|unique:products',
            'description' => 'required|string|max:1000',
            'price' => 'required|numeric|gt:0',
            'quantity' => 'required|numeric|gt:0',
            'sell' => 'required|numeric|gt:price',
        ];
    }

    /**
     * Define validation rules to update method for resource update
     *
     * @return array
     */
    public function updateRules(): array
    {
        return [
            'name' => 'required|string|max:191|unique:products,name,' . $this->get('id'),
            'description' => 'required|string|max:1000',
            'price' => 'required|numeric|gt:0',
            'quantity' => 'required|numeric|gt:0',
            'sell' => 'required|numeric|gt:price',
        ];
    }
}
