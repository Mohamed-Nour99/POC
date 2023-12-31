<?php

namespace Src\Domain\Product\Http\Requests\Product;

use Src\Infrastructure\Http\AbstractRequests\BaseRequest as FormRequest;

class ProductStoreFormRequest extends FormRequest
{
    /**
     * Determine if the Product is authorized to make this request.
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
        $rules = [
            'name_ar'        => ['required', 'string', 'max:255'],
            'name_en'        => ['required', 'string', 'max:255'],           
            'category_id'    => ['required'],
            'image'          => ['required'],

        ];
        return $rules;
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name'        =>  __('main.name'),
        ];
    }

    public function validated($key = null, $default = null)
    {
        $validated = parent::validated();

        $validated['name'] = ['ar' => $validated['name_ar'] , 'en' => $validated['name_en']];

        return $validated ;
    }
}
