<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;

class LivreurRequest extends FormRequest
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
            'name' => 'required|string|max:191',
            'city' => 'required|string|max:191',
            'city_id' => 'required|exists:cities,id',
            'phone' => 'required|string|max:191',
            'email' => 'required|string|email|max:191|unique:shippings',
            'password' => 'required|string|min:6'
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
            'name' => 'required|string|max:191',
            'city' => 'required|string|max:191',
            'city_id' => 'required|exists:cities,id',
            'phone' => 'required|string|max:191',
            'email' => 'sometimes|string|email|max:191|unique:shippings,email,' . $this->get('id')
        ];
    }
}
