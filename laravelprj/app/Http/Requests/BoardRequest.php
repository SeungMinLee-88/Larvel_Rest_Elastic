<?php

namespace App\Http\Requests;

//use Illuminate\Foundation\Http\FormRequest;
use Dingo\Api\Http\Request;
class BoardRequest extends Request
{
    /**
     * Determine if the member is authorized to make this request.
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
                'title'   => 'required',
                'content' => 'required',
            ];
    }
}
