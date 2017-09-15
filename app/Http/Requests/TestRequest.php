<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JenKy\ValidationPresets\ValidatesWithPresets;

class TestRequest extends FormRequest
{
    use ValidatesWithPresets;

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
        return $this->preset(new \App\Validators\TestPreset);
        return [
            //
        ];
    }
}
